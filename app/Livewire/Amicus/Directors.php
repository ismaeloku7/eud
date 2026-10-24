<?php

namespace App\Livewire\Amicus;

use App\Models\Country;
use App\Models\Ministry;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;

/** "Your AMiCUS directors": countries with a director of the AMiCUS ministry and their office. */
class Directors extends Component
{
    public int $ministryId;

    public ?int $country = null;

    public function mount(Ministry $ministry): void
    {
        $this->ministryId = $ministry->id;
        $this->country = $this->countries->first()?->id;
    }

    /** @return Collection<int, Country> */
    #[Computed]
    public function countries(): Collection
    {
        return Country::query()
            ->whereHas('directors', fn ($query) => $query->where('ministry_id', $this->ministryId))
            ->with(['office', 'directors' => fn ($query) => $query->where('ministry_id', $this->ministryId)])
            ->get()
            ->sortBy(fn (Country $country) => (string) $country->name, SORT_NATURAL | SORT_FLAG_CASE)
            ->values();
    }

    #[Computed]
    public function selected(): ?Country
    {
        return $this->countries->firstWhere('id', $this->country) ?? $this->countries->first();
    }

    public function render(): View
    {
        return view('livewire.amicus.directors');
    }
}
