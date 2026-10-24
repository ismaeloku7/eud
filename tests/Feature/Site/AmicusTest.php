<?php

namespace Tests\Feature\Site;

use App\Livewire\Amicus\Directors;
use App\Livewire\Amicus\Resources;
use App\Models\CategoryResource;
use App\Models\Country;
use App\Models\Director;
use App\Models\Event;
use App\Models\Ministry;
use App\Models\OfficeGeneral;
use App\Models\Page;
use App\Models\Resource;
use Database\Seeders\CatalogueSeeder;
use Database\Seeders\MinistrySeeder;
use Database\Seeders\PageSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class AmicusTest extends TestCase
{
    use RefreshDatabase;

    private Ministry $amicus;

    private Resource $picked;

    private Resource $categorised;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed([CatalogueSeeder::class, MinistrySeeder::class, PageSeeder::class]);

        $this->amicus = Ministry::where('slug', 'amicus')->firstOrFail();
        $this->picked = Resource::create(['slug' => 'think-pack', 'title' => ['en' => 'Think Pack']]);
        $this->categorised = Resource::create(['slug' => 'students-guide', 'title' => ['en' => 'Students Guide']]);
        $this->categorised->categories()->attach(CategoryResource::where('name->en', 'AMiCUS Students')->firstOrFail());
        $this->categorised->files()->create(['language_id' => 1, 'file' => 'files/guide.pdf', 'size' => 100]);

        Page::where('slug', 'ministry-amicus')->firstOrFail()->update(['sections' => [
            'about' => ['title' => ['en' => 'AMiCUS is a place to', 'es' => 'AMiCUS es un lugar para']],
            'starting' => ['title' => ['en' => 'Starting Uni Title']],
            'connect' => ['title' => ['en' => 'Connect Title']],
            'think' => ['title' => ['en' => 'Think Title'], 'resources' => [$this->picked->id]],
            'encounter' => ['title' => ['en' => 'Encounter Title']],
            'be' => ['title' => ['en' => 'Be Title'], 'blocks' => [['title' => ['en' => 'Serve block'], 'resources' => [$this->picked->id]]]],
            'act' => ['title' => ['en' => 'Act Title']],
        ]]);
    }

    public function test_every_tab_renders_with_its_section_title(): void
    {
        $titles = [
            null => 'AMiCUS is a place to', 'starting-uni' => 'Starting Uni Title', 'connect' => 'Connect Title', 'think' => 'Think Title',
            'encounter-jesus' => 'Encounter Title', 'be' => 'Be Title', 'act' => 'Act Title', 'resources' => 'Students Guide', 'events' => 'Events',
        ];

        foreach ($titles as $tab => $title) {
            $url = $tab ? "/ministries/amicus/{$tab}" : '/ministries/amicus';

            $this->get($url)->assertOk()->assertSee($title)->assertSee('amicus-sub-nav', false);
        }
    }

    /** All tabs are rendered on one page and switched client side, so other tabs' content is also present. */
    public function test_think_tab_shows_the_resources_picked_in_the_editor(): void
    {
        $this->get('/ministries/amicus/think')
            ->assertOk()
            ->assertSee('Think Pack')
            ->assertSee(route('resources.show', ['slug' => 'think-pack']));
    }

    public function test_be_blocks_render_their_own_resources(): void
    {
        $this->get('/ministries/amicus/be')->assertOk()->assertSee('Serve block')->assertSee('Think Pack');
    }

    public function test_resources_tab_lists_only_the_amicus_category_and_searches(): void
    {
        Livewire::test(Resources::class)
            ->assertSee('Students Guide')
            ->assertDontSee('Think Pack')
            ->set('search', 'nothing-here')
            ->assertDontSee('Students Guide');
    }

    public function test_events_tab_lists_published_events_only(): void
    {
        Event::create(['slug' => ['en' => 'congress'], 'title' => ['en' => 'AMiCUS Congress'], 'date_start' => now(), 'date_end' => now(), 'publish' => true]);
        Event::create(['slug' => ['en' => 'draft'], 'title' => ['en' => 'Draft Event'], 'date_start' => now(), 'date_end' => now(), 'publish' => false]);

        $this->get('/ministries/amicus/events')->assertOk()->assertSee('AMiCUS Congress')->assertDontSee('Draft Event');
    }

    public function test_directors_component_shows_amicus_directors_and_switches_country(): void
    {
        $spain = Country::create(['name' => ['en' => 'Spain']]);
        $italy = Country::create(['name' => ['en' => 'Italy']]);
        $other = Country::create(['name' => ['en' => 'Nowhere']]);
        OfficeGeneral::create(['country_id' => $spain->id, 'title' => ['en' => 'Spanish Union'], 'website' => 'https://aeguae.es']);
        Director::create(['country_id' => $spain->id, 'ministry_id' => $this->amicus->id, 'name' => 'Ana Spain', 'charge' => ['en' => 'AMiCUS leader']]);
        Director::create(['country_id' => $italy->id, 'ministry_id' => $this->amicus->id, 'name' => 'Marco Italy', 'charge' => ['en' => 'AMiCUS leader']]);
        Director::create(['country_id' => $other->id, 'ministry_id' => Ministry::where('slug', 'pathfinders')->value('id'), 'name' => 'Not Amicus', 'charge' => ['en' => 'Pathfinder']]);

        Livewire::test(Directors::class, ['ministry' => $this->amicus])
            ->assertSee('Italy')
            ->assertSee('Marco Italy')
            ->assertDontSee('Nowhere')
            ->set('country', $spain->id)
            ->assertSee('Ana Spain')
            ->assertSee('Spanish Union')
            ->assertDontSee('Marco Italy');
    }

    public function test_spanish_fallback_uses_english_when_a_text_is_missing(): void
    {
        app()->setLocale('es');

        $page = Page::where('slug', 'ministry-amicus')->firstOrFail();

        $this->assertSame('AMiCUS es un lugar para', $page->section('about')->text('title'));
        $this->assertSame('Think Title', $page->section('think')->text('title'));
    }
}
