<?php

namespace Tests\Feature\Admin;

use App\Filament\Resources\Resources\Pages\CreateResource;
use App\Filament\Resources\Resources\Pages\EditResource;
use App\Filament\Resources\Resources\RelationManagers\FilesRelationManager;
use App\Models\CategoryResource;
use App\Models\Language;
use App\Models\Resource;
use App\Models\User;
use Database\Seeders\CatalogueSeeder;
use Filament\Forms\Components\Select;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

/** Selects built with Relations::select: options sorted and searched by their translated label. */
class RelationSelectsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(CatalogueSeeder::class);
        $this->actingAs(User::factory()->create());
    }

    public function test_languages_are_listed_alphabetically_in_the_current_locale(): void
    {
        Language::create(['code' => 'bg', 'name' => ['en' => 'Bulgarian', 'es' => 'Búlgaro']]);
        Language::create(['code' => 'ar', 'name' => ['en' => 'Arabic', 'es' => 'Árabe']]);

        $select = $this->languageSelect();

        $this->assertSame(
            ['Arabic', 'Bulgarian', 'English', 'French', 'German', 'Italian', 'Portuguese', 'Romanian', 'Spanish'],
            array_values($select->getOptions()),
        );

        app()->setLocale('es');

        $this->assertSame(
            ['Alemán', 'Árabe', 'Búlgaro', 'Español', 'Francés', 'Inglés', 'Italiano', 'Portugués', 'Rumano'],
            array_values($select->getOptions()),
        );
    }

    public function test_every_language_is_offered_even_beyond_fifty(): void
    {
        foreach (range(1, 60) as $number) {
            Language::create(['code' => "l{$number}", 'name' => ['en' => sprintf('Language %02d', $number)]]);
        }

        $options = $this->languageSelect()->getOptions();

        $this->assertCount(Language::count(), $options);
        $this->assertContains('Language 60', $options);
    }

    public function test_language_search_ignores_case_and_accents(): void
    {
        $bulgarian = Language::create(['code' => 'bg', 'name' => ['en' => 'Bulgarian', 'es' => 'Búlgaro']]);

        $select = $this->languageSelect();

        $this->assertSame([$bulgarian->id => 'Bulgarian'], $select->getSearchResults('Bulgarian'));
        $this->assertSame([$bulgarian->id => 'Bulgarian'], $select->getSearchResults('BULG'));
        $this->assertSame([], $select->getSearchResults('zzz'));

        app()->setLocale('es');

        $this->assertSame([$bulgarian->id => 'Búlgaro'], $select->getSearchResults('bulgaro'));
        $this->assertSame([$bulgarian->id => 'Búlgaro'], $select->getSearchResults('Búlgaro'));
    }

    public function test_resource_form_classification_selects_are_sorted_too(): void
    {
        CategoryResource::create(['name' => ['en' => 'Zines']]);
        CategoryResource::create(['name' => ['en' => 'Álbum']]);

        /** @var Select $select */
        $select = Livewire::test(CreateResource::class)->instance()->getSchemaComponent('form.categories');

        $labels = array_values($select->getOptions());

        $this->assertSame('Álbum', $labels[0]);
        $this->assertSame('Zines', end($labels));
        $this->assertCount(CategoryResource::count(), $labels);
    }

    private function languageSelect(): Select
    {
        $resource = Resource::create(['slug' => 'manual', 'title' => ['en' => 'Manual']]);

        $livewire = Livewire::test(FilesRelationManager::class, [
            'ownerRecord' => $resource,
            'pageClass' => EditResource::class,
        ])->mountAction('create');

        /** @var Select $select */
        $select = $livewire->instance()->getSchemaComponent('mountedActionSchema0.language_id');

        return $select;
    }
}
