<?php

namespace Tests\Feature\Admin;

use App\Filament\Resources\Pages\Pages\EditPage;
use App\Models\Page;
use App\Models\User;
use App\Pages\Templates;
use Database\Seeders\MinistrySeeder;
use Database\Seeders\PageSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class PagesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed([MinistrySeeder::class, PageSeeder::class]);
        $this->actingAs(User::factory()->create());
    }

    public function test_seeder_creates_one_page_per_template_and_ministry(): void
    {
        $this->assertSame(10, Page::count());
        $this->assertSame('amicus', Page::where('slug', 'ministry-amicus')->first()->template);
        $this->assertSame('ministry', Page::where('slug', 'ministry-pathfinders')->first()->template);
    }

    public function test_every_template_renders_its_editor(): void
    {
        foreach (array_keys(Templates::all()) as $template) {
            $page = Page::where('template', $template)->firstOrFail();

            $this->get("/admin/pages/{$page->id}/edit")->assertOk()->assertSee($page->name);
        }
    }

    public function test_editor_saves_translated_texts_and_repeaters_per_section(): void
    {
        $page = Page::where('slug', 'home')->firstOrFail();

        Livewire::test(EditPage::class, ['record' => $page->getRouteKey()])
            ->fillForm([
                'title' => ['en' => 'EUD Youth', 'es' => 'Jóvenes EUD'],
                'sections' => [
                    'hero' => ['kicker' => ['en' => 'Youth Ministries', 'es' => 'Ministerios Juveniles'], 'button' => ['en' => 'About us']],
                    'about' => ['team' => [['name' => ['en' => 'Jane'], 'role' => ['en' => 'Director']]]],
                ],
            ])
            ->call('save')
            ->assertHasNoFormErrors();

        $page->refresh();

        app()->setLocale('es');
        $this->assertSame('Jóvenes EUD', $page->title);
        $this->assertSame('Ministerios Juveniles', $page->section('hero')->text('kicker'));
        $this->assertSame('About us', $page->section('hero')->text('button'), 'falls back to English');
        $this->assertSame('Jane', $page->section('about')->items('team')[0]->text('name'));
        $this->assertSame('', $page->section('mission')->text('kicker'));
    }

    public function test_section_urls_resolve_uploads_and_legacy_paths(): void
    {
        $page = Page::where('slug', 'home')->firstOrFail();
        $page->update(['sections' => ['hero' => ['image' => 'pages/cover.jpg'], 'about' => ['team' => [['photo' => '/images/old.png']]]]]);

        $this->assertStringEndsWith('/storage/pages/cover.jpg', $page->section('hero')->url('image'));
        $this->assertSame('/images/old.png', $page->section('about')->items('team')[0]->url('photo'));
        $this->assertNull($page->section('mission')->url('image'));
    }

    public function test_page_lookup_cache_is_cleared_on_save(): void
    {
        $page = Page::where('slug', 'mission')->firstOrFail();

        $this->assertSame('Mission', Page::findBySlug('mission')->name);
        $page->update(['name' => 'Our mission']);

        $this->assertSame('Our mission', Page::findBySlug('mission')->name);
    }
}
