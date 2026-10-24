<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class PanelAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_page_is_reachable(): void
    {
        $this->get('/admin/login')->assertOk();
    }

    public function test_guests_are_redirected_to_login(): void
    {
        $this->get('/admin')->assertRedirect('/admin/login');
    }

    public function test_authenticated_user_sees_the_dashboard(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get('/admin')->assertOk();
    }

    public function test_dashboard_reports_the_import_status(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get('/admin')->assertOk()->assertSee('Import of the previous site')->assertSee('Not done');

        DB::table('legacy_imports')->insert(['source' => 'test', 'files_copied' => 5, 'files_missing' => 2, 'warnings' => 0, 'created_at' => now(), 'updated_at' => now()]);

        $this->actingAs($user)->get('/admin')->assertOk()->assertSee('5 files copied');
    }

    public function test_authenticated_user_can_open_the_users_list(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get('/admin/users')->assertOk()->assertSee($user->email);
    }
}
