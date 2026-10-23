<?php

namespace Tests\Feature\Admin;

use App\Models\Country;
use App\Models\Director;
use App\Models\Honor;
use App\Models\Ministry;
use App\Models\Resource;
use App\Models\User;
use Database\Seeders\CatalogueSeeder;
use Database\Seeders\MinistrySeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class ResourcesSmokeTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed([CatalogueSeeder::class, MinistrySeeder::class]);
        $this->actingAs(User::factory()->create());
    }

    public static function indexPages(): array
    {
        return array_map(fn (string $path) => [$path], [
            'ministries', 'resources', 'resource-categories', 'languages', 'type-files',
            'honors', 'category-honors', 'class-honors', 'level-honors', 'master-award-honors',
            'directors', 'countries', 'office-generals', 'type-directors', 'users',
        ]);
    }

    #[DataProvider('indexPages')]
    public function test_every_list_page_renders(string $path): void
    {
        $this->get("/admin/{$path}")->assertOk();
    }

    public function test_create_pages_render(): void
    {
        foreach (['resources', 'honors', 'directors'] as $path) {
            $this->get("/admin/{$path}/create")->assertOk();
        }
    }

    public function test_edit_pages_render_with_translated_relations(): void
    {
        $country = Country::create(['name' => ['en' => 'Spain', 'es' => 'España']]);
        $ministry = Ministry::first();

        $director = Director::create([
            'name' => 'Jane Doe',
            'charge' => ['en' => 'Youth Director', 'es' => 'Directora de Jóvenes'],
            'country_id' => $country->id,
            'ministry_id' => $ministry->id,
        ]);
        $honor = Honor::create([
            'ministry_id' => $ministry->id,
            'category_id' => 1,
            'name' => ['en' => 'Camping', 'es' => 'Acampada'],
        ]);
        $resource = Resource::create(['slug' => 'manual', 'title' => ['en' => 'Manual'], 'collection' => true]);
        $resource->ministries()->attach($ministry);

        $this->get("/admin/directors/{$director->id}/edit")->assertOk()->assertSee('Jane Doe');
        $this->get("/admin/honors/{$honor->id}/edit")->assertOk();
        $this->get("/admin/resources/{$resource->id}/edit")->assertOk();
        $this->get('/admin/directors')->assertOk()->assertSee('Youth Director')->assertSee('Spain');
        $this->get('/admin/honors')->assertOk()->assertSee('Camping')->assertSee('ADRA');
    }
}
