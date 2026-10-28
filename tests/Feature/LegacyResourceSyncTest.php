<?php

namespace Tests\Feature;

use App\Legacy\FileCopier;
use App\Legacy\ImportLog;
use App\Models\CategoryResource;
use App\Models\Language;
use App\Models\Resource;
use App\Models\TypeFile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class LegacyResourceSyncTest extends TestCase
{
    use RefreshDatabase;

    private string $export;

    protected function setUp(): void
    {
        parent::setUp();

        Language::create(['name' => ['en' => 'English'], 'code' => 'en']);
        Language::create(['name' => ['en' => 'Spanish'], 'code' => 'es']);
        TypeFile::create(['name' => 'PDF']);
        CategoryResource::create(['name' => ['en' => 'Pathfinders']]);

        $previous = new FileCopier(null);
        $previous->path('old-upload.pdf');
        ImportLog::record('legacy dump', $previous, 0);

        Resource::create(['slug' => 'existing-guide', 'title' => ['en' => 'Existing Guide'], 'quantity' => 3]);

        $this->export = storage_path('framework/testing/eudyouth-resources.json');
        File::ensureDirectoryExists(dirname($this->export));
        File::put($this->export, json_encode(['resources' => [
            $this->row('existing-guide', 'Existing Guide', ['downloads_eudyouth' => 40]),
            $this->row('friendmanual', 'Friend Achievement Class Manual ', [
                'subtitle' => 'Instructor Manual',
                'quote' => 'A friend to man.',
                'categories' => ['Pathfinders', 'Adventurers'],
                'image' => 'https://eudyouth.org/storage/friend.jpg',
                'languages' => [['id' => '3', 'name' => 'English', 'selected' => true]],
                'download_url' => 'https://eudyouth.org/storage/friend.pdf',
                'file_type' => 'PDF',
                'pages' => '84 pages',
                'size' => '13 MB',
                'author' => 'GC Youth Ministries',
                'downloads_eudyouth' => 29,
            ]),
            $this->row('jesus-the-son-god', 'Jesus, the Son of God', [
                'download_url' => 'https://eudyouth.org/storage/jesus-en.pdf',
                'file_type' => 'PDF',
                'size' => '640 KB',
                'translations' => [
                    ['language' => 'English', 'download_url' => 'https://eudyouth.org/storage/jesus-en.pdf'],
                    ['language' => 'Spanish', 'download_url' => 'https://eudyouth.org/storage/jesus-es.pdf'],
                ],
                'downloads_eudyouth' => 144,
            ]),
            $this->row('theme-song-video', 'Theme Song Video', [
                'download_url' => 'https://www.youtube.com/watch?v=awN0-B8wz6o',
                'file_type' => 'WEB',
                'pages' => 'N/A',
                'downloads_eudyouth' => 1,
            ]),
            $this->row('pathfindermanuals', 'Pathfinder Achievement Class Manuals', [
                'is_collection' => true,
                'collection_items' => [['title' => 'Theme Song Video'], ['title' => 'Friend Achievement Class Manual'], ['title' => 'Unknown Manual']],
            ]),
        ]]));
    }

    protected function tearDown(): void
    {
        File::delete($this->export);

        parent::tearDown();
    }

    public function test_missing_resources_are_created_with_their_files_categories_and_items(): void
    {
        $this->artisan('legacy:sync-resources', ['path' => $this->export])
            ->expectsOutputToContain('Collection item not found: pathfindermanuals: Unknown Manual')
            ->assertSuccessful();

        $friend = Resource::with('files.language', 'files.type', 'categories')->where('slug', 'friendmanual')->firstOrFail();
        $this->assertSame('Friend Achievement Class Manual', $friend->title);
        $this->assertSame('Instructor Manual', $friend->subtitle);
        $this->assertSame('A friend to man.', $friend->legend);
        $this->assertSame('84 pages', $friend->pages);
        $this->assertSame('friend.jpg', $friend->image);
        $this->assertSame(29, $friend->quantity);
        $this->assertSame(['Adventurers', 'Pathfinders'], $friend->categories->pluck('name')->sort()->values()->all());
        $this->assertSame(1, CategoryResource::where('name->en', 'Pathfinders')->count(), 'existing categories are reused');
        $this->assertSame(['friend.pdf', 'English', 'PDF', 13 * 1024 * 1024], [$friend->files[0]->file, $friend->files[0]->language->name, $friend->files[0]->type->name, $friend->files[0]->size]);

        $jesus = Resource::with('files.language')->where('slug', 'jesus-the-son-god')->firstOrFail();
        $this->assertSame(['English' => 'jesus-en.pdf', 'Spanish' => 'jesus-es.pdf'], $jesus->files->mapWithKeys(fn ($file) => [$file->language->name => $file->file])->all());

        $video = Resource::with('files')->where('slug', 'theme-song-video')->firstOrFail();
        $this->assertSame([null, 'https://www.youtube.com/watch?v=awN0-B8wz6o'], [$video->files[0]->file, $video->files[0]->url]);
        $this->assertNull($video->getRawOriginal('pages'), '"N/A" pages are left empty');

        $collection = Resource::where('slug', 'pathfindermanuals')->firstOrFail();
        $this->assertTrue($collection->collection);
        $this->assertSame(['theme-song-video', 'friendmanual'], $collection->items->pluck('slug')->all());

        $this->assertSame(40, Resource::where('slug', 'existing-guide')->value('quantity'));
        $this->assertSame(['old-upload.pdf', 'friend.jpg', 'friend.pdf', 'jesus-en.pdf', 'jesus-es.pdf'], ImportLog::pending(), 'new uploads queue after the ones still pending');
    }

    public function test_with_once_the_export_is_applied_a_single_time(): void
    {
        $this->artisan('legacy:sync-resources', ['path' => $this->export, '--once' => true])->assertSuccessful();
        Resource::where('slug', 'existing-guide')->update(['quantity' => 41]);

        $this->artisan('legacy:sync-resources', ['path' => $this->export, '--once' => true])->assertSuccessful();

        $this->assertSame(41, Resource::where('slug', 'existing-guide')->value('quantity'), 'later downloads are kept');
        $this->assertSame(1, Resource::where('slug', 'friendmanual')->count());
        $this->assertSame(1, DB::table('legacy_imports')->where('source', $this->export)->count());
    }

    /**
     * @param  array<string, mixed>  $overrides
     * @return array<string, mixed>
     */
    private function row(string $slug, string $title, array $overrides = []): array
    {
        return [
            'slug' => $slug,
            'title' => $title,
            'subtitle' => '',
            'quote' => '',
            'categories' => [],
            'image' => null,
            'is_collection' => false,
            'languages' => [],
            'download_url' => '',
            'description_html' => '<div>About it.</div>',
            'collection_items' => [],
            'translations' => [],
            'downloads_eudyouth' => 0,
            ...$overrides,
        ];
    }
}
