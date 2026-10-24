<?php

namespace App\Legacy\Steps;

use App\Legacy\Json;
use App\Legacy\LegacyContext;
use App\Legacy\TableCopy;
use Illuminate\Support\Str;

class MinistriesStep implements ImportStep
{
    public static function name(): string
    {
        return 'ministries';
    }

    public function run(LegacyContext $context): void
    {
        TableCopy::for('ministries')
            ->translatable(['name'])
            ->transform(fn (array $row) => [
                ...$row,
                'slug' => $row['slug'] ?: Str::slug(Json::plain($row['name']) ?? 'ministry-'.$row['id']),
                'position' => $row['id'],
            ])
            ->run($context);
    }
}
