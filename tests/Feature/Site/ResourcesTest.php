<?php

namespace Tests\Feature\Site;

use App\Livewire\Resources\Index;
use App\Models\CategoryResource;
use App\Models\Language;
use App\Models\Ministry;
use App\Models\Resource;
use App\Models\TypeFile;
use Database\Seeders\CatalogueSeeder;
use Database\Seeders\MinistrySeeder;
use Database\Seeders\PageSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class ResourcesTest extends TestCase
{
    use RefreshDatabase;

    private Language $english;

    private Language $spanish;

    private TypeFile $pdf;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed([CatalogueSeeder::class, MinistrySeeder::class, PageSeeder::class]);

        $this->english = Language::where('code', 'en')->firstOrFail();
        $this->spanish = Language::where('code', 'es')->firstOrFail();
        $this->pdf = TypeFile::where('name', 'PDF')->firstOrFail();
    }

    public function test_listing_shows_resources_that_have_files(): void
    {
        $this->resource('Pathfinder Manual', [$this->english]);
        $this->resource('Empty draft', []);

        $this->get('/resources')
            ->assertOk()
            ->assertSee('Pathfinder Manual')
            ->assertDontSee('Empty draft')
            ->assertSee('/resources/pathfinder-manual');
    }

    public function test_filters_by_category_language_and_collections(): void
    {
        $church = CategoryResource::where('name->en', 'Church')->firstOrFail();
        $students = CategoryResource::where('name->en', 'AMiCUS Students')->firstOrFail();

        $manual = $this->resource('Pathfinder Manual', [$this->english], [$church]);
        $guide = $this->resource('Campus Guide', [$this->spanish], [$students]);
        $collection = Resource::create(['slug' => 'starter-kit', 'title' => ['en' => 'Starter Kit'], 'collection' => true]);
        $collection->items()->attach($guide);

        Livewire::test(Index::class)
            ->assertSee('Pathfinder Manual')->assertSee('Campus Guide')->assertSee('Starter Kit')
            ->set('category', (string) $church->id)
            ->assertSee('Pathfinder Manual')->assertDontSee('Campus Guide')->assertDontSee('Starter Kit')
            ->set('category', '')
            ->set('language', (string) $this->spanish->id)
            ->assertDontSee('Pathfinder Manual')->assertSee('Campus Guide')->assertSee('Starter Kit', false)
            ->set('language', '')
            ->set('category', Index::COLLECTIONS)
            ->assertSee('Starter Kit')->assertDontSee('Pathfinder Manual')
            ->call('resetFilters')
            ->assertSet('category', '')
            ->assertSee('Pathfinder Manual');
    }

    public function test_search_matches_title_and_author(): void
    {
        $this->resource('Pathfinder Manual', [$this->english], author: 'EUD Youth');
        $this->resource('Prayer Week', [$this->english], author: 'Jane Doe');

        Livewire::test(Index::class)
            ->set('search', 'manual')
            ->assertSee('Pathfinder Manual')->assertDontSee('Prayer Week')
            ->set('search', 'jane')
            ->assertSee('Prayer Week')->assertDontSee('Pathfinder Manual')
            ->set('search', 'nothing here')
            ->assertSee(__('no resources found'));
    }

    public function test_detail_shows_files_details_and_related_resources(): void
    {
        $manual = $this->resource('Pathfinder Manual', [$this->english, $this->spanish], author: 'EUD Youth');
        $related = $this->resource('Camping Guide', [$this->english]);
        $manual->related()->attach($related);

        $this->get('/resources/pathfinder-manual')
            ->assertOk()
            ->assertSee('Pathfinder Manual')
            ->assertSee('EUD Youth')
            ->assertSee(__('resources.document_details'))
            ->assertSee('English')
            ->assertSee('Spanish')
            ->assertSee(__('resources.you_may_also_like'))
            ->assertSee('Camping Guide')
            ->assertSee(route('resources.download', [$manual, $manual->files->first()]));
    }

    public function test_collection_detail_lists_its_items(): void
    {
        $item = $this->resource('Campus Guide', [$this->english]);
        $collection = Resource::create(['slug' => 'starter-kit', 'title' => ['en' => 'Starter Kit'], 'collection' => true]);
        $collection->items()->attach($item);

        $this->get('/resources/starter-kit')
            ->assertOk()
            ->assertSee(__('resources.in_this_collection'))
            ->assertSee('Campus Guide')
            ->assertDontSee(__('resources.document_details'));
    }

    public function test_download_counts_and_redirects_to_the_file(): void
    {
        $manual = $this->resource('Pathfinder Manual', [$this->english]);
        $file = $manual->files->first();

        $this->post(route('resources.download', [$manual, $file]))
            ->assertRedirect(url('/storage/files/pathfinder-manual-en.pdf'));

        $this->assertSame(1, $manual->fresh()->quantity);
    }

    public function test_download_of_a_file_from_another_resource_is_rejected(): void
    {
        $manual = $this->resource('Pathfinder Manual', [$this->english]);
        $other = $this->resource('Other', [$this->english]);

        $this->post(route('resources.download', [$manual, $other->files->first()]))->assertNotFound();
        $this->assertSame(0, $manual->fresh()->quantity);
    }

    /** @param  array<int, Language>  $languages */
    private function resource(string $title, array $languages, array $categories = [], string $author = 'EUD'): Resource
    {
        $slug = str($title)->slug()->toString();
        $resource = Resource::create(['slug' => $slug, 'title' => ['en' => $title], 'author' => $author, 'description' => ['en' => "<p>About {$title}</p>"]]);
        $resource->ministries()->attach(Ministry::first());
        $resource->categories()->attach(collect($categories)->pluck('id'));

        foreach ($languages as $language) {
            $resource->files()->create([
                'language_id' => $language->id,
                'type_file_id' => $this->pdf->id,
                'file' => "files/{$slug}-{$language->code}.pdf",
                'size' => 2048,
            ]);
        }

        return $resource->load('files');
    }
}
