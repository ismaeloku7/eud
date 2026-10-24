<?php

namespace App\Legacy\Steps;

use App\Legacy\LegacyContext;

interface ImportStep
{
    public static function name(): string;

    public function run(LegacyContext $context): void;
}
