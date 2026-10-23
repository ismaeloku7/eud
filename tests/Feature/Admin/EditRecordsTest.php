<?php

namespace Tests\Feature\Admin;

use App\Filament\Resources\Countries\Pages\ManageCountries;
use App\Filament\Resources\Honors\Pages\CreateHonor;
use App\Filament\Resources\Honors\Pages\EditHonor;
use App\Filament\Resources\Resources\Pages\CreateResource;
use App\Models\Country;
use App\Models\Honor;
use App\Models\Ministry;
use App\Models\Resource;
use App\Models\User;
use Database\Seeders\CatalogueSeeder;
use Database\Seeders\MinistrySeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class EditRecordsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed([CatalogueSeeder::class, MinistrySeeder::class]);
        $this->actingAs(User::factory()->create());
    }

    public function test_an_honor_can_be_created_in_english_and_translated_to_spanish(): void
    {
        Livewire::test(CreateHonor::class)
            ->fillForm([
                'name' => 'Camping',
                'ministry_id' => Ministry::first()->id,
                'category_id' => 1,
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $honor = Honor::first();
        $this->assertSame('Camping', $honor->getTranslation('name', 'en'));

        Livewire::test(EditHonor::class, ['record' => $honor->getRouteKey()])
            ->set('activeLocale', 'es')
            ->fillForm(['name' => 'Acampada'])
            ->call('save')
            ->assertHasNoFormErrors();

        $honor->refresh();
        $this->assertSame('Camping', $honor->getTranslation('name', 'en'));
        $this->assertSame('Acampada', $honor->getTranslation('name', 'es'));
    }

    public function test_a_resource_is_created_with_its_ministries_and_categories(): void
    {
        $ministry = Ministry::where('slug', 'pathfinders')->first();

        Livewire::test(CreateResource::class)
            ->fillForm([
                'title' => 'Pathfinder Manual',
                'slug' => 'pathfinder-manual',
                'author' => 'EUD',
                'ministries' => [$ministry->id],
                'categories' => [1],
                'featured' => true,
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $resource = Resource::where('slug', 'pathfinder-manual')->firstOrFail();
        $this->assertTrue($resource->featured);
        $this->assertTrue($resource->ministries->contains($ministry));
        $this->assertCount(1, $resource->categories);
    }

    public function test_slug_must_be_unique(): void
    {
        Resource::create(['slug' => 'taken', 'title' => ['en' => 'Taken']]);

        Livewire::test(CreateResource::class)
            ->fillForm(['title' => 'Other', 'slug' => 'taken'])
            ->call('create')
            ->assertHasFormErrors(['slug' => 'unique']);
    }

    public function test_countries_are_created_from_the_modal(): void
    {
        Livewire::test(ManageCountries::class)
            ->callAction('create', data: ['name' => 'Portugal'])
            ->assertHasNoActionErrors();

        $this->assertSame('Portugal', Country::first()->getTranslation('name', 'en'));
    }
}
