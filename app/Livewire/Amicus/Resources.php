<?php

namespace App\Livewire\Amicus;

use App\Models\Resource;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

/** Resources tab of AMiCUS: everything filed under the "AMiCUS Students" category. */
class Resources extends Component
{
    use WithPagination;

    #[Url(as: 'q', except: '')]
    public string $search = '';

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function render(): View
    {
        $resources = Resource::query()
            ->whereHas('categories', fn ($query) => $query->where('name->en', 'like', '%AMiCUS%'))
            ->where(fn ($query) => $query->whereHas('files')->orWhere('collection', true))
            ->when(trim($this->search) !== '', fn ($query) => $query->where(function ($query): void {
                $term = '%'.trim($this->search).'%';
                $query->where('title', 'like', $term)->orWhere('subtitle', 'like', $term)->orWhere('author', 'like', $term);
            }))
            ->with('files.type', 'files.language', 'categories')
            ->orderByDesc('updated_at')
            ->paginate(9);

        return view('livewire.amicus.resources', ['resources' => $resources]);
    }
}
