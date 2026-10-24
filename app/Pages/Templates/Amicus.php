<?php

namespace App\Pages\Templates;

use App\Pages\Field;
use App\Pages\Section;
use App\Pages\Template;

/** AMiCUS has its own layout with themed tabs instead of the standard ministry page. */
class Amicus extends Template
{
    public static function key(): string
    {
        return 'amicus';
    }

    public static function label(): string
    {
        return __('AMiCUS page');
    }

    public function sections(): array
    {
        return [
            new Section('about', __('About'), [
                Field::text('title', __('Title')),
                Field::text('we_are_here', __('"We are here" title')),
                Field::rich('we_are_description', __('"We are here" text')),
                Field::text('we_are_quote', __('Quote')),
                Field::url('video_url', __('Video URL')),
            ]),
            new Section('starting', __('Starting uni'), [
                Field::text('title', __('Title')),
                Field::rich('description', __('Text')),
                Field::url('video_url', __('Video URL')),
                Field::text('tips_title', __('Tips: title')),
                Field::rich('tips_description', __('Tips: text')),
                Field::text('resources_title', __('Resources: title')),
                Field::resources('resources', __('Resources to show')),
            ]),
            new Section('connect', __('Connect'), [
                Field::text('title', __('Title')),
                Field::text('quote', __('Quote')),
                Field::image('image', __('Image')),
                Field::text('local_chapter_title', __('Local chapter: title')),
                Field::rich('local_chapter_description', __('Local chapter: text')),
            ]),
            new Section('think', __('Think'), [
                Field::text('title', __('Title')),
                Field::rich('content', __('Text')),
                Field::image('image', __('Image')),
                Field::resources('resources', __('Resources to show')),
            ]),
            new Section('encounter', __('Encounter Jesus'), [
                Field::text('title', __('Title')),
                Field::rich('content', __('Text')),
                Field::image('image', __('Image')),
                Field::resources('resources', __('Resources to show')),
            ]),
            new Section('be', __('Be'), [
                Field::text('title', __('Title')),
                Field::rich('description', __('Text')),
                Field::text('quote', __('Quote')),
                Field::image('image', __('Image')),
                Field::repeater('blocks', __('Blocks'), [
                    Field::text('title', __('Title')),
                    Field::rich('description', __('Text')),
                    Field::resources('resources', __('Resources to show')),
                ]),
            ]),
            new Section('act', __('Act'), [
                Field::text('title', __('Title')),
                Field::rich('description_top', __('Introduction')),
                Field::text('quote', __('Quote')),
                Field::rich('description', __('Text')),
                Field::image('image', __('Image')),
                Field::resources('resources', __('Resources to show')),
            ]),
        ];
    }
}
