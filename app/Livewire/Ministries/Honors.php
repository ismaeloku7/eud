<?php

namespace App\Livewire\Ministries;

use App\Models\CategoryHonor;
use App\Models\ClassHonor;
use App\Models\Honor;
use App\Models\LevelHonor;
use App\Models\MasterAwardHonor;
use App\Models\Ministry;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * Honors / awards tab of a ministry: overview by category, filtered results
 * and the detail of one honor, all on one screen.
 */
class Honors extends Component
{
    use WithPagination;

    public Ministry $ministry;

    /** index | results | show */
    #[Url(as: 'view', except: 'index')]
    public string $view = 'index';

    /** Category whose honors are listed (results after "Show all"). */
    #[Url(as: 'category', except: '')]
    public string $categoryId = '';

    #[Url(as: 'honor', except: '')]
    public string $honorId = '';

    #[Url(as: 'q', except: '')]
    public string $search = '';

    #[Url(as: 'cat', except: '')]
    public string $filterCategory = '';

    #[Url(as: 'class', except: '')]
    public string $filterClass = '';

    #[Url(as: 'master', except: '')]
    public string $filterMasterAward = '';

    #[Url(as: 'level', except: '')]
    public string $filterLevel = '';

    /** Where "back" leads from the detail: index or results. */
    public string $back = 'index';

    /** PDF language chosen on the detail. */
    public string $pdfLanguage = '';

    public function mount(): void
    {
        if ($this->view === 'show' && ! $this->selectedHonor()) {
            $this->view = 'index';
        }

        if ($this->view === 'results' && $this->categoryId !== '' && ! $this->categoryHonors()->exists()) {
            $this->categoryId = '';
            $this->view = 'index';
        }

        if ($this->view === 'show') {
            $this->back = $this->hasFilters() || $this->categoryId !== '' ? 'results' : 'index';
        }
    }

    public function showHonor(int $id): void
    {
        $this->back = $this->view === 'results' ? 'results' : 'index';
        $this->honorId = (string) $id;
        $this->pdfLanguage = '';
        $this->view = 'show';
        $this->dispatch('scrollTop');
    }

    public function showCategory(int $id): void
    {
        $this->resetFilters();
        $this->categoryId = (string) $id;
        $this->view = 'results';
        $this->resetPage();
        $this->dispatch('scrollTop');
    }

    public function searchHonors(): void
    {
        $this->categoryId = '';
        $this->view = 'results';
        $this->resetPage();
        $this->dispatch('scrollTop');
    }

    public function clearFilters(): void
    {
        $this->resetFilters();
    }

    public function toggleLevel(string $id): void
    {
        $this->filterLevel = $this->filterLevel === $id ? '' : $id;
    }

    public function goBack(): void
    {
        if ($this->view === 'show' && $this->back === 'results') {
            $this->view = 'results';
            $this->honorId = '';
        } else {
            $this->view = 'index';
            $this->honorId = '';
            $this->categoryId = '';
        }

        $this->dispatch('scrollTop');
    }

    public function hasFilters(): bool
    {
        return $this->search !== '' || $this->filterCategory !== '' || $this->filterClass !== '' || $this->filterMasterAward !== '' || $this->filterLevel !== '';
    }

    public function selectedHonor(): ?Honor
    {
        if ($this->honorId === '') {
            return null;
        }

        return Honor::query()
            ->where('ministry_id', $this->ministry->id)
            ->with(['category', 'classHonor', 'level', 'masterAward', 'pdfs.language'])
            ->find($this->honorId);
    }

    public function selectedCategory(): ?CategoryHonor
    {
        return $this->categoryId === '' ? null : CategoryHonor::find($this->categoryId);
    }

    public function render(): View
    {
        $data = match ($this->view) {
            'show' => ['honor' => $this->selectedHonor()],
            'results' => ['results' => $this->results(), 'selectedCategory' => $this->selectedCategory()],
            default => ['categories' => $this->categoriesWithHonors()],
        };

        return view('livewire.ministries.honors', [
            ...$data,
            'categoryOptions' => CategoryHonor::query()->orderBy('position')->get()->sortBy('name'),
            'classOptions' => ClassHonor::all()->sortBy('name'),
            'masterAwardOptions' => MasterAwardHonor::all()->sortBy('name'),
            'levelOptions' => LevelHonor::query()->orderBy('id')->get(),
        ]);
    }

    /** @return Collection<int, CategoryHonor> each with its first honors loaded */
    private function categoriesWithHonors(): Collection
    {
        $ministryId = $this->ministry->id;

        return CategoryHonor::query()
            ->whereHas('honors', fn (Builder $query) => $query->where('ministry_id', $ministryId))
            ->withCount(['honors' => fn (Builder $query) => $query->where('ministry_id', $ministryId)])
            ->with(['honors' => fn ($query) => $query->where('ministry_id', $ministryId)->with('classHonor')->orderBy('name')])
            ->orderBy('position')
            ->orderBy('id')
            ->get();
    }

    private function categoryHonors(): Builder
    {
        return Honor::query()->where('ministry_id', $this->ministry->id)->where('category_id', $this->categoryId);
    }

    private function results(): LengthAwarePaginator
    {
        $query = $this->categoryId !== ''
            ? $this->categoryHonors()
            : Honor::query()
                ->where('ministry_id', $this->ministry->id)
                ->when($this->filterCategory !== '', fn (Builder $q) => $q->where('category_id', $this->filterCategory))
                ->when($this->filterClass !== '', fn (Builder $q) => $q->where('class_id', $this->filterClass))
                ->when($this->filterLevel !== '', fn (Builder $q) => $q->where('level_id', $this->filterLevel))
                ->when($this->filterMasterAward !== '', fn (Builder $q) => $q->where('master_award_id', $this->filterMasterAward))
                ->when($this->search !== '', fn (Builder $q) => $q->where('name', 'like', '%'.$this->search.'%'));

        return $query->with(['category', 'classHonor'])->orderBy('name')->paginate(20);
    }

    private function resetFilters(): void
    {
        $this->reset(['search', 'filterCategory', 'filterClass', 'filterMasterAward', 'filterLevel']);
    }
}
