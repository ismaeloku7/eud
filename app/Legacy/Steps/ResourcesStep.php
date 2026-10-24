<?php

namespace App\Legacy\Steps;

use App\Legacy\LegacyContext;
use App\Legacy\TableCopy;

class ResourcesStep implements ImportStep
{
    public static function name(): string
    {
        return 'resources';
    }

    public function run(LegacyContext $context): void
    {
        TableCopy::for('resources')
            ->rename(['destacado' => 'featured'])
            ->translatable(['title', 'subtitle', 'intro', 'description', 'legend', 'pages'])
            ->paths(['image'])
            ->booleans(['collection', 'featured'])
            ->integers(['quantity'])
            ->run($context);

        TableCopy::for('ministry_resources')
            ->requires(['ministry_id' => 'ministries', 'resource_id' => 'resources'])
            ->run($context);

        TableCopy::for('category_resource_resources')
            ->requires(['category_id' => 'category_resources', 'resource_id' => 'resources'])
            ->run($context);

        TableCopy::for('project_resources')
            ->requires(['project_id' => 'resources', 'resource_id' => 'resources'])
            ->transform(fn (array $row) => [...$row, 'position' => $row['id']])
            ->run($context);

        TableCopy::for('related_resources')
            ->requires(['resource_id' => 'resources', 'related_id' => 'resources'])
            ->run($context);

        TableCopy::for('files')
            ->paths(['file'])
            ->integers(['size'])
            ->optional(['language_id' => 'languages', 'type_file_id' => 'type_files'])
            ->transform(fn (array $row) => $row['model_type'] === 'App\\Models\\Resource' && $context->exists('resources', $row['model_id']) ? $row : null)
            ->run($context);
    }
}
