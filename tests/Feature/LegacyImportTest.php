<?php

namespace Tests\Feature;

use App\Models\Country;
use App\Models\Director;
use App\Models\Event;
use App\Models\Honor;
use App\Models\Page;
use App\Models\Resource;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Tests\Support\LegacyDatabase;
use Tests\TestCase;

class LegacyImportTest extends TestCase
{
    use RefreshDatabase;

    private string $legacyRoot;

    protected function setUp(): void
    {
        parent::setUp();

        LegacyDatabase::create();
        Storage::fake('public');
        $this->legacyRoot = sys_get_temp_dir().'/legacy-site-'.uniqid();
        $this->seedLegacy();
    }

    protected function tearDown(): void
    {
        if (is_dir($this->legacyRoot)) {
            exec('rm -rf '.escapeshellarg($this->legacyRoot));
        }

        parent::tearDown();
    }

    public function test_relational_content_is_copied_with_translations_files_and_parents(): void
    {
        $this->artisan('legacy:import', ['--files' => $this->legacyRoot])->assertSuccessful();

        $this->assertSame('editor@eud.test', User::first()->email);
        $this->assertSame('España', Country::find(1)->getTranslation('name', 'es'));
        $this->assertTrue(Country::find(2)->parent->is(Country::find(1)));

        $resource = Resource::find(10);
        $this->assertTrue($resource->featured, 'destacado becomes featured');
        $this->assertSame('Manual del Conquistador', $resource->getTranslation('title', 'es'));
        $this->assertSame('resources/manual.jpg', $resource->image, 'storage paths are kept');
        $this->assertTrue($resource->ministries->contains(3));
        $this->assertSame(2048, $resource->files->first()->size);
        Storage::disk('public')->assertExists('resources/manual.jpg');
        Storage::disk('public')->assertExists('files/manual.pdf');

        $honor = Honor::find(1);
        $this->assertSame('legacy/images/honors/camping.png', $honor->image, 'public images move under legacy/');
        $this->assertNull($honor->level_id, 'dangling level reference becomes null');
        $this->assertSame(1, $honor->pdfs()->count());

        $this->assertSame(1, Director::count(), 'director with a missing country is skipped');

        $event = Event::find(1);
        $this->assertSame('youth-congress', $event->getTranslation('slug', 'en'));
        $this->assertTrue($event->publish);
        $this->assertSame('Hotel', $event->location_recursive[0]['title']['en']);
        $this->assertSame(1, $event->workshops()->first()->schedules()->count());
    }

    public function test_modules_become_page_sections_and_the_amicus_blob_becomes_a_page(): void
    {
        $this->artisan('legacy:import', ['--only' => 'catalogues,ministries,pages'])->assertSuccessful();

        $home = Page::where('slug', 'home')->firstOrFail();
        $this->assertSame('EUD Youth Ministries', $home->section('hero')->text('kicker'));
        $this->assertStringContainsString('love of Jesus', $home->section('hero')->text('heading'));
        $this->assertSame('legacy/images/priscilla-du-preez-nF8xhLMmg0c-unsplash.png', $home->section('hero')->raw('image'));
        $this->assertCount(3, $home->section('about')->items('team'));
        $this->assertCount(6, $home->section('partners')->items('logos'));

        $global = Page::where('slug', 'global')->firstOrFail();
        $this->assertNotSame('', $global->section('navigation')->text('resources'));
        $this->assertNotSame('', $global->section('ministries')->text('honors_title'));

        $ministry = Page::where('slug', 'ministry-cachorros')->firstOrFail();
        $this->assertNotSame('', $ministry->section('cover')->text('title'));
        $this->assertMatchesRegularExpression('/^#/', (string) $ministry->section('cover')->raw('color'));
        $this->assertCount(2, $ministry->section('figures')->items('items'));
        $this->assertCount(8, $ministry->section('all_about')->items('items'));
        $this->assertIsInt($ministry->section('figures')->items('items')[0]->raw('number'));

        $amicus = Page::where('slug', 'ministry-amicus')->firstOrFail();
        $this->assertSame('Think big', $amicus->section('think')->text('title'));
        $this->assertSame([10], $amicus->section('think')->ids('resources'));
        $this->assertSame('Serve', $amicus->section('be')->items('blocks')[0]->text('title'));
    }

    public function test_import_can_be_repeated_without_duplicating_rows(): void
    {
        $this->artisan('legacy:import')->assertSuccessful();
        $this->artisan('legacy:import')->assertSuccessful();

        $this->assertSame(1, Resource::count());
        $this->assertSame(1, Event::count());
        $this->assertSame(3, DB::table('ministries')->count());
    }

    private function seedLegacy(): void
    {
        $legacy = DB::connection('legacy');
        $en = fn (string $en, ?string $es = null) => json_encode(array_filter(['en' => $en, 'es' => $es]));

        $legacy->table('users')->insert(['id' => 1, 'name' => 'Editor', 'email' => 'editor@eud.test', 'password' => bcrypt('secret')]);
        $legacy->table('languages')->insert(['id' => 1, 'name' => $en('English', 'Inglés')]);
        $legacy->table('type_files')->insert(['id' => 1, 'name' => 'PDF']);
        $legacy->table('category_honors')->insert(['id' => 1, 'name' => $en('Nature'), 'color' => '#00ff00']);
        $legacy->table('class_honors')->insert(['id' => 1, 'name' => $en('Not required')]);
        $legacy->table('category_resources')->insert(['id' => 1, 'name' => $en('Church')]);
        $legacy->table('lines')->insert(['id' => 1, 'title' => $en('Leadership'), 'description' => $en(''), 'color' => '#ff0000']);
        $legacy->table('ministries')->insert([
            ['id' => 1, 'name' => $en('CACHORROS'), 'counter' => '100', 'slug' => 'cachorros'],
            ['id' => 3, 'name' => $en('PATHFINDERS'), 'counter' => '200', 'slug' => 'pathfinders'],
            ['id' => 6, 'name' => $en('AMICUS'), 'counter' => '50', 'slug' => 'amicus'],
        ]);
        $legacy->table('countries')->insert([
            ['id' => 1, 'name' => $en('Spain', 'España'), 'image' => '/images/countries/Spain.png', 'country_id' => null],
            ['id' => 2, 'name' => $en('Portugal'), 'image' => '/images/countries/Portugal.png', 'country_id' => 1],
        ]);
        $legacy->table('directors')->insert([
            ['id' => 1, 'country_id' => 1, 'ministry_id' => 3, 'charge' => $en('Youth Director'), 'description' => $en('Bio'), 'name' => 'Jane', 'photo' => 'directors/jane.jpg', 'type_director_id' => null],
            ['id' => 2, 'country_id' => 99, 'ministry_id' => 3, 'charge' => $en('Lost'), 'description' => $en(''), 'name' => 'Ghost', 'photo' => '', 'type_director_id' => null],
        ]);
        $legacy->table('resources')->insert([
            'id' => 10, 'author' => 'EUD', 'title' => $en('Pathfinder Manual', 'Manual del Conquistador'), 'subtitle' => $en(''), 'intro' => '',
            'description' => $en('<p>Text</p>'), 'legend' => $en(''), 'slug' => 'pathfinder-manual', 'quantity' => 7, 'collection' => 0,
            'image' => 'resources/manual.jpg', 'destacado' => 1,
        ]);
        $legacy->table('ministry_resources')->insert(['id' => 1, 'ministry_id' => 3, 'resource_id' => 10]);
        $legacy->table('category_resource_resources')->insert(['id' => 1, 'category_id' => 1, 'resource_id' => 10]);
        $legacy->table('files')->insert(['id' => 1, 'model_type' => 'App\\Models\\Resource', 'model_id' => 10, 'language_id' => 1, 'type_file_id' => 1, 'file' => 'files/manual.pdf', 'size' => '2048']);
        $legacy->table('honors')->insert([
            'id' => 1, 'category_id' => 1, 'class_id' => 1, 'master_award_id' => null, 'level_id' => 42, 'ministry_id' => 3,
            'name' => $en('Camping Skills'), 'description' => $en('<p>Desc</p>'), 'requirements' => $en('<ol><li>Tent</li></ol>'),
            'image' => '/images/honors/camping.png', 'image_secondary' => '/images/Romans-2.png',
        ]);
        $legacy->table('pdf_honors')->insert(['id' => 1, 'language_id' => 1, 'honor_id' => 1, 'name' => $en('Requirements'), 'file' => 'honors/camping.pdf', 'size' => '100']);
        $legacy->table('speakers')->insert(['id' => 1, 'name' => $en('Ana'), 'description' => $en(''), 'type' => $en('Keynote'), 'photo' => null]);
        $legacy->table('schedules')->insert(['id' => 1, 'name' => $en('Morning'), 'date_start' => '2026-07-02 10:00:00', 'date_end' => '2026-07-02 11:00:00']);
        $legacy->table('events')->insert([
            'id' => 1, 'slug' => $en('youth-congress'), 'title' => $en('Youth Congress'), 'subtitle' => $en(''), 'description' => $en('<p>About</p>'),
            'date_start' => '2026-07-01 09:00:00', 'date_end' => '2026-07-05 18:00:00', 'type' => $en('Congress'), 'slogan' => $en(''), 'quote' => $en(''),
            'photo_portada' => 'nova/cover.jpg', 'url_youtube' => '', 'lat' => '', 'long' => '', 'location' => $en('Madrid'), 'url_gallery' => '',
            'registration_eud' => $en(''), 'registration_non_eud' => $en(''), 'tags' => $en(''), 'publish' => 1,
            'location_recursive' => json_encode([['title' => ['en' => 'Hotel'], 'content' => ['en' => '<p>Main street</p>'], 'column' => 2]]),
        ]);
        $legacy->table('localizations')->insert(['id' => 1, 'name' => $en('Room A'), 'capacity' => $en('100'), 'event_id' => 1]);
        $legacy->table('workshops')->insert(['id' => 1, 'title' => $en('Leading teams'), 'description' => $en(''), 'event_id' => 1, 'line_id' => 1, 'video_url' => '']);
        $legacy->table('workshops_schedules')->insert(['id' => 1, 'workshop_id' => 1, 'schedule_id' => 1, 'localization_id' => 1]);
        $legacy->table('events_speakers')->insert(['id' => 1, 'event_id' => 1, 'speaker_id' => 1]);
        $legacy->table('attributes')->insert([
            'id' => 2, 'model_type' => 'App\\Models\\Attribute', 'model_id' => 1, 'key' => 'amicus', 'type' => 'string',
            'value' => json_encode([
                'think_title' => ['en' => 'Think big'], 'think_content' => ['en' => '<p>Ideas</p>'], 'think_resources' => [['id' => 10]],
                'be_title' => ['en' => 'Be'], 'be_recursive' => [['title' => ['en' => 'Serve'], 'description' => ['en' => '<p>Serve others</p>'], 'resources' => [['id' => 10]]]],
                'about_video_url' => 'https://youtu.be/x',
            ]),
        ]);

        LegacyDatabase::loadModules('home', 'about', 'mission', 'global', 'ministry', 'ministry-1');

        foreach (['public/images/honors/camping.png', 'public/images/countries/Spain.png', 'storage/app/public/resources/manual.jpg', 'storage/app/public/files/manual.pdf', 'storage/app/public/honors/camping.pdf'] as $file) {
            @mkdir(dirname("{$this->legacyRoot}/{$file}"), 0777, true);
            file_put_contents("{$this->legacyRoot}/{$file}", 'x');
        }
    }
}
