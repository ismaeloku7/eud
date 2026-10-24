<?php

namespace Tests\Feature;

use App\Legacy\FileCopier;
use App\Legacy\ImportLog;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class LegacyFilesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');
        config()->set('site.legacy.files_url', 'https://old.example');

        $files = new FileCopier(null);
        $files->path('honors/patch.png');
        $files->path('manual.pdf');
        $files->path('gone.pdf');
        $files->path('/images/design.png');
        ImportLog::record('test', $files, 0);
    }

    public function test_import_lists_uploads_to_download_but_not_design_images(): void
    {
        $this->assertSame(['honors/patch.png', 'manual.pdf', 'gone.pdf'], ImportLog::pending());
    }

    public function test_background_command_downloads_pending_files_and_keeps_failures(): void
    {
        Http::fake([
            'old.example/storage/honors/patch.png' => Http::response('png-bytes'),
            'old.example/storage/manual.pdf' => Http::response('pdf-bytes'),
            'old.example/storage/gone.pdf' => Http::response('', 404),
        ]);

        $this->artisan('legacy:fetch-files')->assertSuccessful();

        Storage::disk('public')->assertExists('honors/patch.png');
        $this->assertSame('pdf-bytes', Storage::disk('public')->get('manual.pdf'));
        $this->assertSame(['gone.pdf'], ImportLog::pending());
        $this->assertSame(2, DB::table('legacy_imports')->value('files_copied'));
        $this->assertSame(1, DB::table('legacy_imports')->value('files_missing'));
    }

    public function test_a_visitor_requesting_a_pending_file_gets_it_downloaded_on_the_spot(): void
    {
        Http::fake(['old.example/storage/honors/patch.png' => Http::response('png-bytes')]);

        $this->get('/storage/honors/patch.png')->assertOk();

        Storage::disk('public')->assertExists('honors/patch.png');
    }

    public function test_only_known_pending_paths_are_fetched(): void
    {
        Http::fake();

        $this->get('/storage/not-from-the-old-site.png')->assertNotFound();
        $this->get('/storage/..%2F.env')->assertNotFound();

        Http::assertNothingSent();
    }

    public function test_safe_target_rejects_traversal_and_hidden_segments(): void
    {
        $this->assertTrue(FileCopier::isSafeTarget('honors/patch.png'));
        $this->assertFalse(FileCopier::isSafeTarget('../.env'));
        $this->assertFalse(FileCopier::isSafeTarget('/etc/passwd'));
        $this->assertFalse(FileCopier::isSafeTarget('a/.git/config'));
    }
}
