<?php

namespace App\Pages\Templates;

use App\Pages\Field;
use App\Pages\Section;
use App\Pages\Template;

/** The "General" tab of a ministry (Cachorros, Adventurers, Pathfinders...). */
class Ministry extends Template
{
    public static function key(): string
    {
        return 'ministry';
    }

    public static function label(): string
    {
        return __('Ministry page');
    }

    public function sections(): array
    {
        return [
            new Section('cover', __('Cover'), [
                Field::text('title', __('Title')),
                Field::color('color', __('Background colour')),
                Field::image('logo', __('Logo')),
                Field::image('pattern', __('Background pattern')),
                Field::image('photo', __('Cover photo')),
            ]),
            new Section('intro', __('Introduction'), [
                Field::text('title', __('Title')),
                Field::rich('text', __('Text')),
                Field::text('secondary_title', __('Secondary title')),
                Field::rich('secondary_text', __('Secondary text')),
                Field::repeater('downloads', __('Download cards'), [
                    Field::text('title', __('Title')),
                    Field::text('subtitle', __('Subtitle')),
                    Field::image('image', __('Image')),
                    Field::file('file', __('File')),
                ], max: 2),
            ]),
            new Section('highlights', __('Highlights'), [
                Field::repeater('items', __('Highlights'), [
                    Field::text('title', __('Title')),
                    Field::rich('text', __('Text')),
                    Field::image('image', __('Image')),
                    Field::url('link', __('Link')),
                ], max: 4),
            ]),
            new Section('philosophy', __('Philosophy'), [
                Field::text('title', __('Title')),
                Field::rich('text', __('Text')),
                Field::text('secondary_title', __('Secondary title')),
                Field::rich('secondary_text', __('Secondary text')),
            ]),
            new Section('figures', __('Figures'), [
                Field::repeater('items', __('Counters'), [
                    Field::number('number', __('Number')),
                    Field::rich('text', __('Text')),
                    Field::image('icon', __('Icon')),
                ], max: 2),
            ]),
            new Section('identity', __('Identity'), [
                Field::text('link', __('Link')),
                Field::text('subtitle', __('Subtitle')),
                Field::rich('text', __('Text')),
                Field::image('image', __('Main image')),
                Field::text('file_label', __('Download label')),
                Field::file('file', __('Download file')),
                Field::text('card_class', __('Card style class'), __('Advanced: CSS class of the card.')),
                Field::text('name_class', __('Name style class'), __('Advanced: CSS class of the name.')),
                Field::text('image_class', __('Image style class'), __('Advanced: CSS class of the image.')),
                Field::repeater('logos', __('Emblems'), [
                    Field::text('title', __('Title')),
                    Field::rich('text', __('Text')),
                    Field::image('image', __('Image')),
                ], max: 8),
            ]),
            new Section('all_about', __('All about'), [
                Field::repeater('items', __('Cards'), [
                    Field::text('title', __('Title')),
                    Field::text('link', __('Link')),
                    Field::image('image', __('Image')),
                ], max: 8),
            ]),
            new Section('countries', __('Our countries'), [
                Field::text('title', __('Title')),
            ]),
        ];
    }
}
