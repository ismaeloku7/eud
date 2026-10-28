<?php

namespace App\Livewire\Resources;

use App\Models\CategoryResource;
use App\Models\Language;
use App\Models\Resource;
use App\Models\TypeFile;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cookie;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * Resources listing: filters by category (or collections), file type, language,
 * free text and sort order, with a grid / list presentation switch.
 */
class Index extends Component
{
    use WithPagination;

    /** Special category value that lists collections only. */
    public const COLLECTIONS = 'collections';

    #[Url(except: '')]
    public string $category = '';

    #[Url(except: '')]
    public string $type = '';

    #[Url(except: '')]
    public string $language = '';

    #[Url(except: '')]
    public string $search = '';

    #[Url(except: '')]
    public string $sort = '';

    public string $view = 'grid';

    public function mount(): void
    {
        $this->view = Cookie::get('resources-view') === 'list' ? 'list' : 'grid';

        if ($this->category !== '' && $this->category !== self::COLLECTIONS && ! CategoryResource::query()->whereKey($this->category)->exists()) {
            $this->category = '';
        }

        if ($this->type !== '' && ! TypeFile::query()->whereKey($this->type)->exists()) {
            $this->type = '';
        }

        if ($this->language !== '' && ! Language::query()->whereKey($this->language)->exists()) {
            $this->language = '';
        }
    }

    public function updating(string $property): void
    {
        if (in_array($property, ['category', 'type', 'language', 'search', 'sort'], true)) {
            $this->resetPage();
        }
    }

    public function resetFilters(): void
    {
        $this->reset(['category', 'type', 'language', 'search', 'sort']);
        $this->resetPage();
    }

    public function setView(string $view): void
    {
        $this->view = $view === 'list' ? 'list' : 'grid';
        Cookie::queue('resources-view', $this->view, 60 * 24 * 365);
    }

    public function hasFilters(): bool
    {
        return $this->category !== '' || $this->type !== '' || $this->language !== '' || $this->search !== '';
    }

    public function render(): View
    {
        return view('livewire.resources.index', [
            'resources' => $this->query()->paginate(12),
            'categories' => $this->catalogue(CategoryResource::class),
            'types' => $this->catalogue(TypeFile::class),
            'languages' => $this->catalogue(Language::class),
        ]);
    }

    /** @return Builder<resource> */
    private function query(): Builder
    {
        $files = fn (Builder $query) => $query
            ->when($this->type !== '', fn (Builder $q) => $q->where('type_file_id', $this->type))
            ->when($this->language !== '', fn (Builder $q) => $q->where('language_id', $this->language));

        return Resource::query()
            ->with(['categories', 'files.type'])
            ->when($this->category === self::COLLECTIONS, fn (Builder $query) => $query->where('collection', true))
            ->when($this->category !== '' && $this->category !== self::COLLECTIONS, fn (Builder $query) => $query
                ->whereHas('categories', fn (Builder $q) => $q->where('category_resources.id', $this->category)))
            ->when($this->search !== '', fn (Builder $query) => $query->where(fn (Builder $q) => $q
                ->where('title', 'like', "%{$this->search}%")
                ->orWhere('subtitle', 'like', "%{$this->search}%")
                ->orWhere('author', 'like', "%{$this->search}%")))
            ->where(fn (Builder $query) => $query
                ->where(fn (Builder $q) => $q->where('collection', false)->whereHas('files', $files))
                ->orWhere(fn (Builder $q) => $q->where('collection', true)->whereHas('items', fn (Builder $item) => $item->whereHas('files', $files))))
            ->when(
                $this->sort === 'newest', fn (Builder $query) => $query->orderByDesc('created_at'),
                fn (Builder $query) => $query
                    ->when($this->sort === 'oldest', fn (Builder $q) => $q->orderBy('created_at'))
                    ->when(! in_array($this->sort, ['newest', 'oldest'], true), fn (Builder $q) => $this->orderByTitle($q, $this->sort === 'desc' ? 'desc' : 'asc')),
            );
    }

    /**
     * Alphabetical by title in the current language (English when it has none),
     * ignoring case so "bibleproject.com" sorts with the B's, as on the old site.
     *
     * @param  Builder<resource>  $query
     */
    private function orderByTitle(Builder $query, string $direction): void
    {
        $grammar = $query->getQuery()->getGrammar();
        $fallback = $grammar->wrap('title->'.config('app.fallback_locale'));
        $localized = $grammar->wrap('title->'.app()->getLocale());

        $query->orderByRaw("lower(coalesce({$localized}, {$fallback})) {$direction}");
    }

    /**
     * @param  class-string<Model>  $model
     * @return Collection<int, Model>
     */
    private function catalogue(string $model): Collection
    {
        return $model::query()->get()->sortBy(fn ($row) => mb_strtolower((string) $row->name))->values();
    }
}
