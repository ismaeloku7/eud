<?php

namespace Tests\Feature;

use App\Console\Commands\SiteSetupCommand;
use App\Models\Ministry;
use App\Models\Page;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Facades\Storage;
use Tests\Support\LegacyDatabase;
use Tests\TestCase;

class SiteSetupTest extends TestCase
{
    use RefreshDatabase;

    private string $bundle;

    private ?string $originalBundle = null;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');
        $this->bundle = base_path(SiteSetupCommand::BUNDLED_DUMP);
        $this->originalBundle = File::exists($this->bundle) ? File::get($this->bundle) : null;
    }

    protected function tearDown(): void
    {
        $this->originalBundle === null ? File::delete($this->bundle) : File::put($this->bundle, $this->originalBundle);

        parent::tearDown();
    }

    public function test_first_deploy_imports_the_bundled_dump_once_and_keeps_the_admin(): void
    {
        $this->bundleLegacyDatabase();
        config()->set('site.admin', ['name' => 'Owner', 'email' => 'owner@eud.test', 'password' => 'first-password']);

        $this->artisan('site:setup')->assertSuccessful();

        $this->assertSame(1, DB::table('legacy_imports')->count());
        $this->assertSame('Pathfinders', Ministry::where('slug', 'pathfinders')->first()->getTranslation('name', 'en'));
        $this->assertSame('EUD Youth Ministries', Page::where('slug', 'home')->first()->section('hero')->text('kicker'));
        $this->assertTrue(User::where('email', 'editor@eud.test')->exists());

        Ministry::where('slug', 'pathfinders')->first()->update(['counter' => '9999']);
        config()->set('site.admin.password', 'changed-in-env');

        $this->artisan('site:setup')->assertSuccessful();

        $this->assertSame(1, DB::table('legacy_imports')->count(), 'second deploy does not import again');
        $this->assertSame('9999', Ministry::where('slug', 'pathfinders')->first()->counter, 'edits survive later deploys');
        $this->assertTrue(Hash::check('first-password', User::where('email', 'owner@eud.test')->value('password')));
    }

    public function test_without_a_bundled_dump_an_empty_site_gets_catalogues_and_pages(): void
    {
        File::delete($this->bundle);

        $this->artisan('site:setup')->assertSuccessful();

        $this->assertSame(0, DB::table('legacy_imports')->count());
        $this->assertSame(6, Ministry::count());
        $this->assertTrue(Page::where('slug', 'ministry-amicus')->exists());
    }

    public function test_the_bundled_dump_is_not_ignored_by_git(): void
    {
        $result = Process::path(base_path())->run(['git', 'check-ignore', '--quiet', SiteSetupCommand::BUNDLED_DUMP]);

        $this->assertSame(1, $result->exitCode(), 'A .gitignore rule would keep the data file out of the deploy.');
    }

    private function bundleLegacyDatabase(): void
    {
        $path = LegacyDatabase::create();
        $legacy = DB::connection('legacy');
        $legacy->table('users')->insert(['id' => 1, 'name' => 'Editor', 'email' => 'editor@eud.test', 'password' => bcrypt('secret')]);
        $legacy->table('ministries')->insert(['id' => 3, 'name' => json_encode(['en' => 'Pathfinders']), 'counter' => '1', 'slug' => 'pathfinders']);
        LegacyDatabase::loadModules('home');
        DB::purge('legacy');

        File::ensureDirectoryExists(dirname($this->bundle));
        File::put($this->bundle, gzencode(File::get($path)));
    }
}
