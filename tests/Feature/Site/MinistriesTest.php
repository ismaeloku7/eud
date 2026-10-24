<?php

namespace Tests\Feature\Site;

use App\Livewire\Ministries\CountryDirectors;
use App\Livewire\Ministries\Honors;
use App\Models\Country;
use App\Models\Director;
use App\Models\Honor;
use App\Models\Ministry;
use App\Models\Page;
use Database\Seeders\CatalogueSeeder;
use Database\Seeders\MinistrySeeder;
use Database\Seeders\PageSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class MinistriesTest extends TestCase
{
    use RefreshDatabase;

    private Ministry $pathfinders;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed([CatalogueSeeder::class, MinistrySeeder::class, PageSeeder::class]);
        $this->pathfinders = Ministry::where('slug', 'pathfinders')->firstOrFail();
    }

    public function test_every_tab_of_every_ministry_renders(): void
    {
        foreach (Ministry::where('slug', '!=', 'amicus')->get() as $ministry) {
            $this->get("/ministries/{$ministry->slug}")->assertOk();

            foreach (config("site.ministries.{$ministry->slug}.tabs") as $tab) {
                $this->get("/ministries/{$ministry->slug}/{$tab['slug']}")->assertOk();
            }
        }
    }

    public function test_general_tab_shows_the_page_sections(): void
    {
        Page::where('slug', 'ministry-pathfinders')->firstOrFail()->update(['sections' => [
            'cover' => ['title' => ['en' => 'Pathfinder Ministries'], 'color' => '#123456'],
            'intro' => ['title' => ['en' => 'Who we are'], 'text' => ['en' => '<p>Intro text</p>']],
            'philosophy' => ['title' => ['en' => 'Our aim'], 'text' => ['en' => '<p>Aim text</p>']],
            'figures' => ['items' => [['number' => 7782, 'text' => ['en' => 'Pathfinders in Europe']]]],
            'all_about' => ['items' => [['title' => ['en' => 'Camporee'], 'link' => 'https://example.org']]],
        ]]);

        $this->get('/ministries/pathfinders')
            ->assertOk()
            ->assertSee('Pathfinder Ministries')
            ->assertSee('#123456')
            ->assertSee('Who we are')
            ->assertSee('Intro text')
            ->assertSee('Our aim')
            ->assertSee('7,782')
            ->assertSee('Camporee')
            ->assertSee('https://example.org')
            ->assertSee('/ministries/pathfinders/honors');
    }

    public function test_general_tab_lists_featured_honors_linking_to_their_detail(): void
    {
        $honor = $this->makeHonor('Camping Skills');

        $this->get('/ministries/pathfinders')
            ->assertOk()
            ->assertSee('Camping Skills')
            ->assertSee("/ministries/pathfinders/honors?view=show&honor={$honor->id}", false);
    }

    public function test_honors_tab_groups_honors_by_category_and_opens_a_detail(): void
    {
        $camping = $this->makeHonor('Camping Skills', categoryId: 5, levelId: 1);
        $this->makeHonor('Swimming', categoryId: 7);

        Livewire::test(Honors::class, ['ministry' => $this->pathfinders])
            ->assertSee('Nature')
            ->assertSee('Recreation')
            ->assertSee('Camping Skills')
            ->call('showHonor', $camping->id)
            ->assertSet('view', 'show')
            ->assertSee('Requirement one')
            ->assertSee('Level 1')
            ->call('goBack')
            ->assertSet('view', 'index');
    }

    public function test_honors_can_be_filtered_by_category_level_and_name(): void
    {
        $this->makeHonor('Camping Skills', categoryId: 5, levelId: 1);
        $this->makeHonor('Trees', categoryId: 5, levelId: 2);
        $this->makeHonor('Swimming', categoryId: 7, levelId: 1);

        Livewire::test(Honors::class, ['ministry' => $this->pathfinders])
            ->set('filterCategory', '5')
            ->call('searchHonors')
            ->assertSet('view', 'results')
            ->assertSee('Camping Skills')
            ->assertSee('Trees')
            ->assertDontSee('Swimming')
            ->call('toggleLevel', '1')
            ->assertSee('Camping Skills')
            ->assertDontSee('Trees')
            ->set('search', 'tre')
            ->call('clearFilters')
            ->set('search', 'swim')
            ->call('searchHonors')
            ->assertSee('Swimming')
            ->assertDontSee('Camping Skills');
    }

    public function test_honors_of_other_ministries_are_not_shown(): void
    {
        $this->makeHonor('Only for adventurers', ministryId: Ministry::where('slug', 'adventurers')->value('id'));

        Livewire::test(Honors::class, ['ministry' => $this->pathfinders])
            ->assertDontSee('Only for adventurers')
            ->assertSee('There are no honors');
    }

    public function test_honor_detail_in_url_belongs_to_the_ministry_or_falls_back_to_index(): void
    {
        $other = $this->makeHonor('Foreign', ministryId: Ministry::where('slug', 'adventurers')->value('id'));

        Livewire::withQueryParams(['view' => 'show', 'honor' => $other->id])
            ->test(Honors::class, ['ministry' => $this->pathfinders])
            ->assertSet('view', 'index');
    }

    public function test_our_countries_tab_lists_countries_with_directors_of_the_ministry(): void
    {
        $spain = Country::create(['name' => ['en' => 'Spain']]);
        $france = Country::create(['name' => ['en' => 'France']]);
        Director::create(['name' => 'Jane Doe', 'country_id' => $spain->id, 'ministry_id' => $this->pathfinders->id, 'type_director_id' => 2, 'charge' => ['en' => 'Pathfinder Director']]);
        Director::create(['name' => 'Other Ministry', 'country_id' => $france->id, 'ministry_id' => Ministry::where('slug', 'adventurers')->value('id')]);

        $this->get('/ministries/pathfinders/our-countries')->assertOk()->assertSee('Spain')->assertDontSee('France');

        Livewire::test(CountryDirectors::class, ['ministry' => $this->pathfinders])
            ->assertSee('Jane Doe')
            ->assertSee('Pathfinder Director')
            ->assertDontSee('Other Ministry');
    }

    public function test_curriculum_tab_shows_the_static_content_of_the_ministry(): void
    {
        $this->get('/ministries/pathfinders/curriculum')->assertOk()->assertSee('Achievement Classes')->assertSee('Companion');
        $this->get('/ministries/cachorros/curriculum')->assertOk()->assertSee('Squirrels');
        $this->get('/ministries/young-adults/curriculum')->assertOk();
    }

    private function makeHonor(string $name, int $categoryId = 5, ?int $levelId = null, ?int $ministryId = null): Honor
    {
        return Honor::create([
            'ministry_id' => $ministryId ?? $this->pathfinders->id,
            'category_id' => $categoryId,
            'class_id' => 1,
            'level_id' => $levelId,
            'name' => ['en' => $name],
            'description' => ['en' => "<p>About {$name}</p>"],
            'requirements' => ['en' => '<ol><li>Requirement one</li></ol>'],
        ]);
    }
}
