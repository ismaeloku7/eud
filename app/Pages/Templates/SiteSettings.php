<?php

namespace App\Pages\Templates;

use App\Pages\Field;
use App\Pages\Section;
use App\Pages\Template;

/** Texts shared by every page: navigation, footer, contact and ministry section titles. */
class SiteSettings extends Template
{
    public static function key(): string
    {
        return 'global';
    }

    public static function label(): string
    {
        return __('Site settings');
    }

    public function sections(): array
    {
        return [
            new Section('navigation', __('Navigation'), [
                Field::text('ministries', __('Menu: Ministries')),
                Field::text('resources', __('Menu: Resources')),
                Field::text('events', __('Menu: Events')),
                Field::text('mission', __('Menu: Mission')),
                Field::text('about', __('Menu: About us')),
                Field::text('contact', __('Menu: Contact')),
            ]),
            new Section('brand', __('Logo and footer'), [
                Field::image('logo', __('Logo')),
                Field::rich('tagline', __('Text next to the logo')),
                Field::rich('footer', __('Footer text')),
            ]),
            new Section('contact', __('Contact details'), [
                Field::text('email', __('Email')),
                Field::text('phone', __('Phone')),
                Field::text('address', __('Address')),
                Field::url('facebook', 'Facebook'),
                Field::url('instagram', 'Instagram'),
                Field::url('youtube', 'YouTube'),
                Field::url('twitter', 'X / Twitter'),
            ]),
            new Section('ministries', __('Ministry pages'), [
                Field::text('ministries_menu_title', __('Title of the ministries menu')),
                Field::text('honors_title', __('Featured honors: title')),
                Field::text('honors_button', __('Featured honors: button label')),
                Field::text('all_about_title', __('"All about" section title')),
                Field::text('countries_title', __('"Our countries" section title')),
                Field::text('resources_title', __('Resources section title')),
            ]),
        ];
    }
}
