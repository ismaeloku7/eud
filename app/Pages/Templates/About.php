<?php

namespace App\Pages\Templates;

use App\Pages\Field;
use App\Pages\Section;
use App\Pages\Template;

class About extends Template
{
    public static function key(): string
    {
        return 'about';
    }

    public static function label(): string
    {
        return __('About page');
    }

    public function sections(): array
    {
        return [
            new Section('intro', __('Introduction'), [
                Field::text('kicker', __('Small title')),
                Field::rich('heading', __('Heading')),
                Field::rich('text', __('Text')),
            ]),
            new Section('team', __('Team'), [
                Field::repeater('members', __('Members'), [
                    Field::text('name', __('Name')),
                    Field::text('role', __('Role')),
                    Field::image('photo', __('Photo')),
                ], max: 6),
            ]),
        ];
    }
}
