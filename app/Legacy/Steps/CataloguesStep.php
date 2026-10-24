<?php

namespace App\Legacy\Steps;

use App\Legacy\LegacyContext;
use App\Legacy\TableCopy;

class CataloguesStep implements ImportStep
{
    public static function name(): string
    {
        return 'catalogues';
    }

    public function run(LegacyContext $context): void
    {
        TableCopy::for('languages')->translatable(['name'])->run($context);
        TableCopy::for('type_files')->plain(['name'])->run($context);
        TableCopy::for('type_directors')->translatable(['name'])->run($context);
        TableCopy::for('category_honors')->translatable(['name'])
            ->transform(fn (array $row) => [...$row, 'color' => $row['color'] ?: '#6847c3', 'position' => $row['id']])
            ->run($context);
        TableCopy::for('class_honors')->translatable(['name'])->run($context);
        TableCopy::for('level_honors')->translatable(['name'])->run($context);
        TableCopy::for('master_award_honors')->translatable(['name'])->run($context);
        TableCopy::for('category_resources')->translatable(['name'])->run($context);
        TableCopy::for('lines')->translatable(['title', 'description'])->run($context);
    }
}
