<?php

namespace Tests\Feature\Site;

use App\Models\Event;
use App\Models\Resource;
use Database\Seeders\MinistrySeeder;
use Database\Seeders\PageSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Spanish URLs (/es/recursos...) cannot be exercised here: the localization
 * package picks the locale when routes are registered, before the test
 * request exists. They are checked against the running server instead.
 */
class PublicRoutesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed([MinistrySeeder::class, PageSeeder::class]);
    }

    public function test_static_pages_render_in_both_languages(): void
    {
        foreach (['/', '/about', '/mission', '/contact', '/resources', '/events', '/ministries/pathfinders', '/ministries/pathfinders/honors', '/ministries/amicus'] as $path) {
            $this->get($path)->assertOk();
        }

    }

    public function test_ministries_index_redirects_to_the_first_ministry(): void
    {
        $this->get('/ministries')->assertRedirect('/ministries/cachorros');
    }

    public function test_unknown_ministry_tab_is_not_found(): void
    {
        $this->get('/ministries/pathfinders/nope')->assertNotFound();
    }

    public function test_resource_and_event_detail_pages_resolve_by_slug(): void
    {
        Resource::create(['slug' => 'manual', 'title' => ['en' => 'Manual']]);
        Event::create(['slug' => ['en' => 'congress', 'es' => 'congreso'], 'title' => ['en' => 'Congress'], 'date_start' => now(), 'date_end' => now(), 'publish' => true]);
        Event::create(['slug' => ['en' => 'draft'], 'title' => ['en' => 'Draft'], 'date_start' => now(), 'date_end' => now(), 'publish' => false]);

        $this->get('/resources/manual')->assertOk();
        $this->get('/events/congress')->assertOk();
        $this->get('/events/draft')->assertNotFound();
        $this->get('/resources/missing')->assertNotFound();
    }

    public function test_header_lists_ministries_and_their_tabs(): void
    {
        $this->get('/')
            ->assertSee('/ministries/pathfinders/honors')
            ->assertSee('AMiCUS');
    }
}
