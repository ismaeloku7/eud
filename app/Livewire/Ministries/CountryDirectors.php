<?php

namespace App\Livewire\Ministries;

use App\Models\Country;
use App\Models\Ministry;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;

/**
 * "Our countries": a country picker with the directors of the ministry in
 * that country and, optionally, the union office contact details.
 */
class CountryDirectors extends Component
{
    public Ministry $ministry;

    public string $title = '';

    public bool $withOffice = false;

    public string $countryId = '';

    public function mount(): void
    {
        $this->countryId = (string) ($this->countries->first()?->id ?? '');
    }

    /** @return Collection<int, Country> */
    #[Computed(persist: true)]
    public function countries(): Collection
    {
        $ministryId = $this->ministry->id;

        return Country::query()
            ->whereHas('directors', fn (Builder $query) => $query->where('ministry_id', $ministryId))
            ->with(['directors' => fn ($query) => $query->where('ministry_id', $ministryId)->with('type'), 'office', 'parent.office'])
            ->get()
            ->sortBy(fn (Country $country) => (string) $country->name, SORT_NATURAL | SORT_FLAG_CASE)
            ->values();
    }

    public function selected(): ?Country
    {
        return $this->countries->first(fn (Country $country) => (string) $country->id === $this->countryId);
    }

    public function render(): View
    {
        $country = $this->selected();
        $directors = $country?->directors ?? collect();

        // The previous site showed youth directors first and fell back to pathfinder directors.
        $primary = $directors->where('type_director_id', 1);

        return view('livewire.ministries.country-directors', [
            'country' => $country,
            'directors' => ($primary->isNotEmpty() ? $primary : $directors)->take(3),
            'office' => $country?->office ?? $country?->parent?->office,
        ]);
    }
}
