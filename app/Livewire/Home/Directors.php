<?php

namespace App\Livewire\Home;

use App\Models\Country;
use App\Models\OfficeGeneral;
use Illuminate\Support\Collection;
use Livewire\Component;

/** "Your youth directors": pick a country, see its directors and union office. */
class Directors extends Component
{
    public string $title = '';

    public ?int $country = null;

    public function mount(string $title = ''): void
    {
        $this->title = $title;
        $this->country = $this->countries()->first()?->id;
    }

    /** @return Collection<int, Country> */
    public function countries(): Collection
    {
        return Country::query()
            ->where(fn ($query) => $query->has('directors')->orHas('office')->orHas('parent.office'))
            ->with(['directors.ministry', 'office', 'parent.office'])
            ->get()
            ->sortBy(fn (Country $country) => mb_strtolower((string) $country->name))
            ->values();
    }

    public function render()
    {
        $countries = $this->countries();
        $selected = $countries->firstWhere('id', $this->country) ?? $countries->first();

        return view('livewire.home.directors', [
            'countries' => $countries,
            'selected' => $selected,
            'directors' => $selected?->directors->take(3) ?? collect(),
            'office' => $this->officeFor($selected),
        ]);
    }

    /** The office of the country itself or, for members of a union, the union's office. */
    private function officeFor(?Country $country): ?OfficeGeneral
    {
        return $country?->office ?? $country?->parent?->office;
    }
}
