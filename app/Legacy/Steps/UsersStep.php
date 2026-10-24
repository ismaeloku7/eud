<?php

namespace App\Legacy\Steps;

use App\Legacy\LegacyContext;
use App\Legacy\TableCopy;

/** Editors keep their e-mail and password hash; team and 2FA columns are dropped. */
class UsersStep implements ImportStep
{
    public static function name(): string
    {
        return 'users';
    }

    public function run(LegacyContext $context): void
    {
        TableCopy::for('users')->where(fn ($query) => $query->whereNotNull('email'))->run($context);
    }
}
