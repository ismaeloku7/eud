<?php

namespace App\Legacy\Steps;

use App\Legacy\LegacyContext;
use Illuminate\Support\Facades\DB;

/**
 * Editors keep their e-mail and password hash. Matched by e-mail, never by
 * id, so accounts created on the new site are not overwritten.
 */
class UsersStep implements ImportStep
{
    public static function name(): string
    {
        return 'users';
    }

    public function run(LegacyContext $context): void
    {
        $added = 0;

        foreach ($context->legacy->table('users')->whereNotNull('email')->orderBy('id')->get() as $user) {
            if (DB::table('users')->where('email', $user->email)->exists()) {
                continue;
            }

            DB::table('users')->insert([
                'name' => $user->name ?: $user->email,
                'email' => $user->email,
                'password' => $user->password,
                'email_verified_at' => $user->email_verified_at ?? null,
                'created_at' => $user->created_at ?? now(),
                'updated_at' => now(),
            ]);
            $added++;
        }

        $context->info(sprintf('%-32s %5d rows', 'users', $added));
    }
}
