<?php

namespace App\Legacy;

use App\Models\CategoryResource;
use App\Models\Language;
use App\Models\Resource;
use App\Models\TypeFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use RuntimeException;

/**
 * Brings the resources list up to date with eudyouth.org from a JSON export
 * of its public pages (config site.legacy.resources_export): creates the
 * resources published after the database dump was taken, with their files,
 * categories and collection items, and copies every download counter.
 *
 * Uploads stay on eudyouth.org and are queued as pending legacy files, so they
 * are downloaded in the background or on first request like the main import.
 */
final class EudyouthResourceSync
{
    private const FILES_HOST = 'eudyouth.org';

    /** @var array<string, int> lower-cased name => id */
    private array $categories = [];

    /** @var array<string, int> */
    private array $languages = [];

    /** @var array<string, int> */
    private array $types = [];

    /** @var array<int, string> */
    private array $pendingFiles = [];

    /**
     * @return array{created: array<int, string>, counters: int, missing_items: array<int, string>, files: array<int, string>}
     */
    public function run(string $path): array
    {
        $rows = json_decode((string) file_get_contents($path), true)['resources'] ?? null;

        if (! is_array($rows)) {
            throw new RuntimeException("No resources found in {$path}.");
        }

        $this->pendingFiles = [];
        $this->loadCatalogues();

        return DB::transaction(function () use ($rows): array {
            $created = [];
            $missingItems = [];

            // Single resources first: collections link to them by title.
            foreach (collect($rows)->sortBy(fn (array $row): int => $row['is_collection'] ? 1 : 0) as $row) {
                if (Resource::where('slug', $row['slug'])->exists()) {
                    continue;
                }

                $resource = $this->createResource($row);
                $created[] = $row['slug'];

                if ($row['is_collection']) {
                    $missingItems = [...$missingItems, ...$this->attachItems($resource, $row['collection_items'] ?? [])];
                }
            }

            $counters = 0;

            foreach ($rows as $row) {
                $counters += Resource::where('slug', $row['slug'])->update(['quantity' => (int) ($row['downloads_eudyouth'] ?? 0)]);
            }

            return [
                'created' => $created,
                'counters' => $counters,
                'missing_items' => $missingItems,
                'files' => array_values(array_unique($this->pendingFiles)),
            ];
        });
    }

    /** @param  array<string, mixed>  $row */
    private function createResource(array $row): Resource
    {
        $text = fn (?string $value): ?array => filled(trim((string) $value)) ? ['en' => trim((string) $value)] : null;
        $pages = in_array(trim((string) ($row['pages'] ?? '')), ['', 'N/A'], true) ? null : $row['pages'];

        $resource = Resource::create(array_filter([
            'slug' => $row['slug'],
            'title' => ['en' => trim($row['title'])],
            'subtitle' => $text($row['subtitle'] ?? null),
            'legend' => $text($row['quote'] ?? null),
            'description' => $text($row['description_html'] ?? null),
            'pages' => $text($pages),
            'author' => filled($row['author'] ?? null) ? trim($row['author']) : null,
            'image' => $this->storagePath($row['image'] ?? null),
            'collection' => (bool) $row['is_collection'],
            'quantity' => (int) ($row['downloads_eudyouth'] ?? 0),
        ], fn (mixed $value): bool => $value !== null));

        $resource->categories()->attach(collect($row['categories'] ?? [])->map(fn (string $name): int => $this->categoryId($name))->unique()->all());

        if (! $row['is_collection']) {
            $this->createFiles($resource, $row);
        }

        return $resource;
    }

    /**
     * One file per language version, or the single download in the selected language.
     *
     * @param  array<string, mixed>  $row
     */
    private function createFiles(Resource $resource, array $row): void
    {
        $versions = collect($row['translations'] ?? [])
            ->map(fn (array $version): array => ['language' => $version['language'], 'url' => $version['download_url']]);

        if ($versions->isEmpty() && filled($row['download_url'] ?? null)) {
            $language = collect($row['languages'] ?? [])->firstWhere('selected', true) ?? ($row['languages'][0] ?? null);
            $versions = collect([['language' => $language['name'] ?? null, 'url' => $row['download_url']]]);
        }

        foreach ($versions->filter(fn (array $version): bool => filled($version['url'])) as $version) {
            $storagePath = $this->storagePath($version['url']);

            $resource->files()->create([
                'language_id' => $this->languages[Str::lower((string) $version['language'])] ?? null,
                'type_file_id' => $this->types[Str::upper((string) ($row['file_type'] ?? ''))] ?? null,
                'file' => $storagePath,
                'url' => $storagePath ? null : $version['url'],
                'size' => $version['url'] === $row['download_url'] ? $this->bytes($row['size'] ?? null) : 0,
            ]);
        }
    }

    /**
     * @param  array<int, array{title: string}>  $items
     * @return array<int, string> titles that match no resource
     */
    private function attachItems(Resource $collection, array $items): array
    {
        $missing = [];

        foreach (array_values($items) as $position => $item) {
            $title = Str::lower(trim($item['title']));
            $resource = Resource::where('collection', false)->get()
                ->first(fn (Resource $candidate): bool => Str::lower(trim((string) $candidate->getTranslation('title', 'en', false))) === $title);

            if ($resource) {
                $collection->items()->attach($resource->id, ['position' => $position + 1]);
            } else {
                $missing[] = "{$collection->slug}: {$item['title']}";
            }
        }

        return $missing;
    }

    /** Relative path on the public disk for an eudyouth.org upload, queued for download; null for other URLs. */
    private function storagePath(?string $url): ?string
    {
        if (blank($url) || parse_url($url, PHP_URL_HOST) !== self::FILES_HOST) {
            return null;
        }

        $path = Str::after((string) parse_url($url, PHP_URL_PATH), '/storage/');

        if (! FileCopier::isSafeTarget($path)) {
            return null;
        }

        $this->pendingFiles[] = $path;

        return $path;
    }

    /** "11 MB" / "640 KB" / "0 Bytes" as bytes. */
    private function bytes(?string $size): int
    {
        if (! preg_match('/^([\d.]+)\s*(bytes|kb|mb|gb)$/i', trim((string) $size), $match)) {
            return 0;
        }

        $power = ['bytes' => 0, 'kb' => 1, 'mb' => 2, 'gb' => 3][Str::lower($match[2])];

        return (int) round((float) $match[1] * 1024 ** $power);
    }

    private function categoryId(string $name): int
    {
        return $this->categories[Str::lower($name)] ??= CategoryResource::create(['name' => ['en' => $name]])->id;
    }

    private function loadCatalogues(): void
    {
        $byEnglishName = fn ($models): array => $models
            ->mapWithKeys(fn ($model): array => [Str::lower((string) $model->getTranslation('name', 'en', false)) => $model->id])
            ->all();

        $this->categories = $byEnglishName(CategoryResource::all());
        $this->languages = $byEnglishName(Language::all());
        $this->types = TypeFile::all()->mapWithKeys(fn (TypeFile $type): array => [Str::upper($type->name) => $type->id])->all();
    }
}
