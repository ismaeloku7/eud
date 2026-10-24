<?php

namespace App\Pages\Templates;

use App\Pages\Field;
use App\Pages\Section;
use App\Pages\Template;

class Mission extends Template
{
    public static function key(): string
    {
        return 'mission';
    }

    public static function label(): string
    {
        return __('Mission page');
    }

    public function sections(): array
    {
        return [
            new Section('intro', __('Content'), [
                Field::text('kicker', __('Small title')),
                Field::rich('heading', __('Heading')),
                Field::rich('text', __('Text')),
            ]),
        ];
    }
}
