<?php

namespace App\Pages\Templates;

use App\Pages\Field;
use App\Pages\Section;
use App\Pages\Template;

class Home extends Template
{
    public static function key(): string
    {
        return 'home';
    }

    public static function label(): string
    {
        return __('Home page');
    }

    public function sections(): array
    {
        return [
            new Section('hero', __('Cover'), [
                Field::text('kicker', __('Small title'), __('Short line above the heading, e.g. "EUD Youth Ministries".')),
                Field::rich('heading', __('Heading'), __('Large text of the cover. Use bold to highlight words.')),
                Field::text('button', __('Button label')),
                Field::image('image', __('Background image')),
            ]),
            new Section('mission', __('Mission'), [
                Field::text('kicker', __('Small title')),
                Field::rich('heading', __('Heading')),
                Field::rich('text', __('Text')),
                Field::text('button', __('Button label')),
            ]),
            new Section('about', __('About us'), [
                Field::text('kicker', __('Small title')),
                Field::rich('heading', __('Heading')),
                Field::rich('text', __('Text')),
                Field::text('button', __('Button label')),
                Field::repeater('team', __('Team'), [
                    Field::text('name', __('Name')),
                    Field::text('role', __('Role')),
                    Field::text('email', __('Email')),
                    Field::image('photo', __('Photo')),
                ], max: 3),
                Field::text('directors_title', __('Title of the directors list')),
            ]),
            new Section('partners', __('Logos strip'), [
                Field::text('title', __('Title')),
                Field::repeater('logos', __('Logos'), [
                    Field::image('image', __('Logo')),
                    Field::url('link', __('Link')),
                ], max: 8),
            ]),
            new Section('contact', __('Contact'), [
                Field::text('kicker', __('Small title')),
                Field::rich('heading', __('Heading')),
                Field::rich('text', __('Text')),
                Field::text('button', __('Button label')),
            ]),
        ];
    }
}
