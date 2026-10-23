<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * Creates the first admin from ADMIN_EMAIL / ADMIN_PASSWORD. No credentials
 * live in the repository; without those variables nothing is created and
 * `php artisan make:filament-user` can be used instead.
 */
class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $email = env('ADMIN_EMAIL');
        $password = env('ADMIN_PASSWORD');

        if (! $email || ! $password) {
            $this->command?->warn('ADMIN_EMAIL / ADMIN_PASSWORD not set: no admin user created.');

            return;
        }

        User::updateOrCreate(
            ['email' => $email],
            ['name' => env('ADMIN_NAME', 'Admin'), 'password' => Hash::make($password)],
        );
    }
}
