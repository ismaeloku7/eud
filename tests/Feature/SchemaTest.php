<?php

namespace Tests\Feature;

use App\Models\Country;
use App\Models\Honor;
use App\Models\Ministry;
use App\Models\Page;
use App\Models\Resource;
use Database\Seeders\CatalogueSeeder;
use Database\Seeders\MinistrySeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SchemaTest extends TestCase
{
    use RefreshDatabase;

    public function test_seeders_populate_the_catalogues(): void
    {
        $this->seed([CatalogueSeeder::class, MinistrySeeder::class]);

        $this->assertSame(6, Ministry::count());
        $this->assertSame('Conquistadores', Ministry::where('slug', 'pathfinders')->first()->getTranslation('name', 'es'));
    }

    public function test_translatable_columns_store_one_value_per_locale(): void
    {
        $resource = Resource::create([
            'slug' => 'manual',
            'title' => ['en' => 'Manual', 'es' => 'Manual en español'],
        ]);

        app()->setLocale('es');
        $this->assertSame('Manual en español', $resource->fresh()->title);
        app()->setLocale('en');
        $this->assertSame('Manual', $resource->fresh()->title);
    }

    public function test_honor_relations_resolve(): void
    {
        $this->seed([CatalogueSeeder::class, MinistrySeeder::class]);

        $honor = Honor::create([
            'ministry_id' => Ministry::first()->id,
            'category_id' => 1,
            'class_id' => 1,
            'name' => ['en' => 'Camping'],
        ]);

        $this->assertSame('ADRA', $honor->category->name);
        $this->assertSame('Not required', $honor->classHonor->name);
        $this->assertNull($honor->level);
    }

    public function test_pages_store_blocks_per_locale(): void
    {
        $page = Page::create([
            'name' => 'Home',
            'slug' => 'home',
            'blocks' => ['en' => [['type' => 'hero', 'data' => ['title' => 'Welcome']]]],
        ]);

        $this->assertSame('Welcome', $page->fresh()->getTranslation('blocks', 'en')[0]['data']['title']);
        $this->assertSame([], $page->fresh()->getTranslation('blocks', 'es', false) ?: []);
    }

    public function test_country_can_belong_to_a_parent_country(): void
    {
        $union = Country::create(['name' => ['en' => 'Franco-Belgian Union']]);
        $country = Country::create(['name' => ['en' => 'Belgium'], 'country_id' => $union->id]);

        $this->assertTrue($country->parent->is($union));
        $this->assertCount(1, $union->children);
    }
}
