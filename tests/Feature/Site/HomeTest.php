<?php

namespace Tests\Feature\Site;

use App\Livewire\Home\Directors;
use App\Models\Country;
use App\Models\Director;
use App\Models\Event;
use App\Models\Language;
use App\Models\Ministry;
use App\Models\OfficeGeneral;
use App\Models\Page;
use App\Models\Resource;
use Database\Seeders\MinistrySeeder;
use Database\Seeders\PageSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class HomeTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed([MinistrySeeder::class, PageSeeder::class]);
    }

    public function test_ministry_names_are_uppercase_on_the_home_page(): void
    {
        $this->get('/')->assertOk()->assertSeeInOrder(['PATHFINDERS', 'PATHFINDERS']);
    }

    public function test_home_shows_page_texts_ministries_featured_resources_and_events(): void
    {
        Page::where('slug', 'home')->first()->update(['sections' => [
            'hero' => ['kicker' => ['en' => 'EUD Youth Ministries'], 'heading' => ['en' => '<strong>Empowering</strong> youth'], 'button' => ['en' => 'ABOUT US']],
            'mission' => ['kicker' => ['en' => 'MISSION'], 'heading' => ['en' => 'Vivid Faith'], 'button' => ['en' => 'Volunteer today!']],
            'about' => ['heading' => ['en' => 'Children and Youth'], 'team' => [['name' => ['en' => 'Jonatán Tejel'], 'role' => ['en' => 'Youth Director'], 'email' => ['en' => 'jt@eud.test']]], 'directors_title' => ['en' => 'YOUR YOUTH DIRECTORS']],
            'partners' => ['title' => ['en' => 'IN THE INTER-EUROPEAN DIVISION']],
            'contact' => ['heading' => ['en' => 'How can we help you?']],
        ]]);

        Ministry::first()->update(['counter' => '2180']);
        $language = Language::create(['name' => ['en' => 'English']]);
        $featured = Resource::create(['slug' => 'pathfinder-manual', 'title' => ['en' => 'Pathfinder Manual'], 'featured' => true]);
        $featured->files()->create(['language_id' => $language->id, 'file' => 'files/manual.pdf']);
        Resource::create(['slug' => 'hidden-collection', 'title' => ['en' => 'Hidden Collection'], 'featured' => true, 'collection' => true]);
        Resource::create(['slug' => 'no-files', 'title' => ['en' => 'Without Files'], 'featured' => true]);
        Event::create(['slug' => ['en' => 'congress'], 'title' => ['en' => 'Youth Congress'], 'date_start' => now(), 'date_end' => now(), 'publish' => true]);
        Event::create(['slug' => ['en' => 'draft'], 'title' => ['en' => 'Draft Event'], 'date_start' => now(), 'date_end' => now(), 'publish' => false]);

        $response = $this->get('/')->assertOk();

        $response
            ->assertSee('EUD Youth Ministries')
            ->assertSee('Empowering', false)
            ->assertSee('Vivid Faith')
            ->assertSee('Jonatán Tejel')
            ->assertSee('IN THE INTER-EUROPEAN DIVISION')
            ->assertSee('How can we help you?')
            ->assertSee('Pathfinder Manual')
            ->assertSee('/resources/pathfinder-manual')
            ->assertDontSee('Hidden Collection')
            ->assertDontSee('Without Files')
            ->assertSee('Youth Congress')
            ->assertSee('/events/congress')
            ->assertDontSee('Draft Event')
            ->assertSee('data-target="2180"', false);

        foreach (Ministry::all() as $ministry) {
            $response->assertSee('/ministries/'.$ministry->slug);
        }
    }

    public function test_about_mission_and_contact_render_their_page_content(): void
    {
        Page::where('slug', 'about')->first()->update(['sections' => ['intro' => ['heading' => ['en' => 'Who we are']], 'team' => ['members' => [['name' => ['en' => 'Jane Doe'], 'role' => ['en' => 'Director']]]]]]);
        Page::where('slug', 'mission')->first()->update(['sections' => ['intro' => ['heading' => ['en' => 'Our mission'], 'text' => ['en' => '<p>Serve others</p>']]]]);
        Page::where('slug', 'global')->first()->update(['sections' => ['contact' => ['email' => ['en' => 'hello@eud.test'], 'phone' => ['en' => '+41 31 000']]]]);

        $this->get('/about')->assertOk()->assertSee('Who we are')->assertSee('Jane Doe');
        $this->get('/mission')->assertOk()->assertSee('Our mission')->assertSee('Serve others');
        $this->get('/contact')->assertOk()->assertSee('mailto:hello@eud.test', false)->assertSee('+41 31 000');
    }

    public function test_directors_component_switches_country_and_falls_back_to_the_union_office(): void
    {
        $ministry = Ministry::first();
        $union = Country::create(['name' => ['en' => 'Franco-Belgian Union']]);
        OfficeGeneral::create(['country_id' => $union->id, 'title' => ['en' => 'Union Office'], 'phone' => '+32 2 000', 'website' => 'fbu.example']);
        $belgium = Country::create(['name' => ['en' => 'Belgium'], 'country_id' => $union->id]);
        $spain = Country::create(['name' => ['en' => 'Spain']]);
        OfficeGeneral::create(['country_id' => $spain->id, 'title' => ['en' => 'Spanish Union'], 'email' => 'office@es.test']);
        Country::create(['name' => ['en' => 'Empty Country']]);

        foreach (['Ana', 'Ben', 'Carla', 'Dani'] as $name) {
            Director::create(['name' => $name, 'country_id' => $spain->id, 'ministry_id' => $ministry->id, 'charge' => ['en' => 'Youth Director']]);
        }
        Director::create(['name' => 'Luc', 'country_id' => $belgium->id, 'ministry_id' => $ministry->id, 'charge' => ['en' => 'Pathfinder Director'], 'instagram' => 'https://instagram.com/luc']);

        Livewire::test(Directors::class, ['title' => 'YOUR YOUTH DIRECTORS'])
            ->assertSee('YOUR YOUTH DIRECTORS')
            ->assertSee('Belgium')
            ->assertDontSee('Empty Country')
            ->assertSee('Luc')
            ->assertSee('Union Office')
            ->assertSee('https://fbu.example')
            ->set('country', $spain->id)
            ->assertSee('Ana')
            ->assertSee('Carla')
            ->assertDontSee('Dani')
            ->assertSee('Spanish Union')
            ->assertDontSee('Luc');
    }
}
