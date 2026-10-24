<?php

namespace App\Legacy\Steps;

use App\Legacy\LegacyContext;
use App\Legacy\TableCopy;

class HonorsStep implements ImportStep
{
    public static function name(): string
    {
        return 'honors';
    }

    public function run(LegacyContext $context): void
    {
        TableCopy::for('honors')
            ->translatable(['name', 'description', 'requirements'])
            ->paths(['image', 'image_secondary'])
            ->requires(['ministry_id' => 'ministries', 'category_id' => 'category_honors'])
            ->optional(['class_id' => 'class_honors', 'level_id' => 'level_honors', 'master_award_id' => 'master_award_honors'])
            ->run($context);

        TableCopy::for('pdf_honors')
            ->translatable(['name'])
            ->paths(['file'])
            ->integers(['size'])
            ->requires(['honor_id' => 'honors', 'language_id' => 'languages'])
            ->run($context);
    }
}
