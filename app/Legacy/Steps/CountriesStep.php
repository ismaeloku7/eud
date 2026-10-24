<?php

namespace App\Legacy\Steps;

use App\Legacy\LegacyContext;
use App\Legacy\TableCopy;
use Illuminate\Support\Facades\DB;

/** Countries reference each other (unions), so the parent link is set in a second pass. */
class CountriesStep implements ImportStep
{
    public static function name(): string
    {
        return 'countries';
    }

    public function run(LegacyContext $context): void
    {
        $parents = $context->legacy->table('countries')->whereNotNull('country_id')->pluck('country_id', 'id');

        TableCopy::for('countries')
            ->translatable(['name'])
            ->paths(['image'])
            ->transform(fn (array $row) => [...$row, 'country_id' => null])
            ->run($context);

        foreach ($parents as $id => $parentId) {
            if ($context->exists('countries', $parentId)) {
                DB::table('countries')->where('id', $id)->update(['country_id' => $parentId]);
            }
        }
    }
}
