<?php

namespace App\Livewire\Ministries;

use App\Models\Ministry;
use App\Models\Resource;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;

/** Up to three downloadable resources of a ministry, with a language picker per resource. */
class CurriculumResources extends Component
{
    public Ministry $ministry;

    /** @var array<int, int> resource id => chosen file id */
    public array $selectedFiles = [];

    /** @return Collection<int, resource> */
    #[Computed(persist: true)]
    public function resources(): Collection
    {
        $ministryId = $this->ministry->id;

        return Resource::query()
            ->where('collection', false)
            ->whereHas('files')
            ->whereHas('ministries', fn (Builder $query) => $query->where('ministries.id', $ministryId))
            ->with(['files.language', 'files.type'])
            ->take(3)
            ->get();
    }

    public function render(): View
    {
        return view('livewire.ministries.curriculum-resources');
    }
}
