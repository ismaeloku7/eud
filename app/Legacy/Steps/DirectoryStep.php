<?php

namespace App\Legacy\Steps;

use App\Legacy\LegacyContext;
use App\Legacy\TableCopy;

class DirectoryStep implements ImportStep
{
    public static function name(): string
    {
        return 'directory';
    }

    public function run(LegacyContext $context): void
    {
        TableCopy::for('directors')
            ->translatable(['charge', 'description'])
            ->paths(['photo'])
            ->requires(['country_id' => 'countries', 'ministry_id' => 'ministries'])
            ->optional(['type_director_id' => 'type_directors'])
            ->run($context);

        TableCopy::for('office_generals')
            ->translatable(['title', 'description'])
            ->requires(['country_id' => 'countries'])
            ->run($context);
    }
}
