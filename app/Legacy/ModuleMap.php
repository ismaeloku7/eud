<?php

namespace App\Legacy;

/**
 * Where each legacy "module" (template + title_1 / content_2 style fields)
 * lands in the new page templates. Keys are new field names, values the
 * legacy field names; list rules append one repeater item per module.
 *
 * @phpstan-type Rule array{pattern: string, section: string, list?: string, fields: array<string, string>}
 */
final class ModuleMap
{
    /** @return array<int, Rule> */
    public static function rules(string $template): array
    {
        return match ($template) {
            'home' => [
                ['pattern' => '/^home-main$/', 'section' => 'hero', 'fields' => ['kicker' => 'title_1', 'button' => 'title_2', 'heading' => 'content_1', 'image' => 'image_1']],
                ['pattern' => '/^home-mission$/', 'section' => 'mission', 'fields' => ['kicker' => 'title_1', 'button' => 'title_2', 'heading' => 'content_1', 'text' => 'content_2']],
                ['pattern' => '/^home-about$/', 'section' => 'about', 'fields' => ['kicker' => 'title_1', 'button' => 'title_2', 'directors_title' => 'title_3', 'heading' => 'content_1', 'text' => 'content_2']],
                ['pattern' => '/^home-about-director-(\d+)$/', 'section' => 'about', 'list' => 'team', 'fields' => ['name' => 'title_1', 'role' => 'title_2', 'email' => 'title_3', 'photo' => 'image_1']],
                ['pattern' => '/^home-counter$/', 'section' => 'partners', 'fields' => ['title' => 'title_1']],
                ['pattern' => '/^home-counter-(\d+)$/', 'section' => 'partners', 'list' => 'logos', 'fields' => ['image' => 'image_1']],
                ['pattern' => '/^home-contact$/', 'section' => 'contact', 'fields' => ['kicker' => 'title_1', 'button' => 'title_2', 'heading' => 'content_1', 'text' => 'content_2']],
            ],
            'about' => [
                ['pattern' => '/^about$/', 'section' => 'intro', 'fields' => ['kicker' => 'title_1', 'heading' => 'content_1', 'text' => 'content_2']],
                ['pattern' => '/^about-director-(\d+)$/', 'section' => 'team', 'list' => 'members', 'fields' => ['name' => 'title_1', 'role' => 'title_2', 'photo' => 'image_1']],
            ],
            'mission' => [
                ['pattern' => '/^mission$/', 'section' => 'intro', 'fields' => ['kicker' => 'title_1', 'heading' => 'content_1', 'text' => 'content_2']],
            ],
            'global' => [
                ['pattern' => '/^global-nav$/', 'section' => 'navigation', 'fields' => ['ministries' => 'title_1', 'resources' => 'title_2', 'events' => 'title_3', 'mission' => 'title_4', 'about' => 'title_5']],
                ['pattern' => '/^global-nav-logo$/', 'section' => 'brand', 'fields' => ['logo' => 'image_1', 'tagline' => 'content_1']],
                ['pattern' => '/^global-nav-social$/', 'section' => 'contact', 'fields' => ['email' => 'title_1', 'facebook' => 'title_2', 'instagram' => 'title_3']],
                ['pattern' => '/^global-nav-ministry$/', 'section' => 'ministries', 'fields' => ['ministries_menu_title' => 'title_1']],
                ['pattern' => '/^ministry-general-featured-honors$/', 'section' => 'ministries', 'fields' => ['honors_title' => 'title_1', 'honors_button' => 'title_2']],
                ['pattern' => '/^ministry-general-section-all-about$/', 'section' => 'ministries', 'fields' => ['all_about_title' => 'title_1']],
                ['pattern' => '/^ministry-general-section-maps$/', 'section' => 'ministries', 'fields' => ['countries_title' => 'title_1']],
            ],
            'ministry' => [
                ['pattern' => '/^portada$/', 'section' => 'cover', 'fields' => ['title' => 'title_1', 'color' => 'color_1', 'logo' => 'image_1', 'pattern' => 'image_2', 'photo' => 'image_3']],
                ['pattern' => '/^main-1$/', 'section' => 'intro', 'fields' => ['title' => 'title_1', 'text' => 'content_1']],
                ['pattern' => '/^main-2$/', 'section' => 'intro', 'fields' => ['secondary_title' => 'title_1', 'secondary_text' => 'content_1']],
                ['pattern' => '/^main-([34])$/', 'section' => 'intro', 'list' => 'downloads', 'fields' => ['title' => 'title_1', 'subtitle' => 'title_2', 'image' => 'image_1', 'file' => 'file_1']],
                ['pattern' => '/^headline-(\d+)$/', 'section' => 'highlights', 'list' => 'items', 'fields' => ['title' => 'title_1', 'link' => 'title_2', 'text' => 'content_1', 'image' => 'image_1']],
                ['pattern' => '/^philosophy-1$/', 'section' => 'philosophy', 'fields' => ['title' => 'title_1', 'text' => 'content_1']],
                ['pattern' => '/^philosophy-2$/', 'section' => 'philosophy', 'fields' => ['secondary_title' => 'title_1', 'secondary_text' => 'content_1']],
                ['pattern' => '/^counter-(\d+)$/', 'section' => 'figures', 'list' => 'items', 'fields' => ['number' => 'cant_1', 'text' => 'content_1', 'icon' => 'image_1']],
                ['pattern' => '/^logo$/', 'section' => 'identity', 'fields' => ['link' => 'title_1', 'subtitle' => 'title_2', 'file_label' => 'title_3', 'card_class' => 'title_4', 'name_class' => 'title_5', 'image_class' => 'title_6', 'text' => 'content_1', 'image' => 'image_1', 'file' => 'file_1']],
                ['pattern' => '/^logo-(\d+)$/', 'section' => 'identity', 'list' => 'logos', 'fields' => ['title' => 'title_1', 'text' => 'content_1', 'image' => 'image_1']],
                ['pattern' => '/^all-about-(\d+)$/', 'section' => 'all_about', 'list' => 'items', 'fields' => ['title' => 'title_1', 'link' => 'title_2', 'image' => 'image_1']],
                ['pattern' => '/^maps$/', 'section' => 'countries', 'fields' => ['title' => 'title_1']],
            ],
            default => [],
        };
    }

    /**
     * The legacy "amicus" attribute blob, keyed by new section and field.
     *
     * @return array<string, array<string, string>>
     */
    public static function amicus(): array
    {
        return [
            'about' => ['title' => 'about_amicus_title', 'we_are_here' => 'about_we_are_here', 'we_are_description' => 'about_we_are_description', 'we_are_quote' => 'about_we_are_quote', 'video_url' => 'about_video_url'],
            'starting' => ['title' => 'starting_uni_title', 'description' => 'starting_uni_description', 'video_url' => 'starting_uni_video_url', 'tips_title' => 'starting_uni_tips_title', 'tips_description' => 'starting_uni_tips_description', 'resources_title' => 'starting_uni_resources_title', 'resources' => 'starting_uni_resources_list'],
            'connect' => ['title' => 'connect_title', 'quote' => 'connect_quote', 'image' => 'connect_image', 'local_chapter_title' => 'connect_local_chapter_title', 'local_chapter_description' => 'connect_local_chapter_description'],
            'think' => ['title' => 'think_title', 'content' => 'think_content', 'image' => 'think_image', 'resources' => 'think_resources'],
            'encounter' => ['title' => 'encounter_jesus_title', 'content' => 'encounter_jesus_content', 'image' => 'encounter_jesus_image', 'resources' => 'encounter_jesus_resources'],
            'be' => ['title' => 'be_title', 'description' => 'be_description', 'quote' => 'be_quote', 'image' => 'be_image', 'blocks' => 'be_recursive'],
            'act' => ['title' => 'act_title', 'description_top' => 'act_description_top', 'quote' => 'act_quote', 'description' => 'act_description', 'image' => 'act_image', 'resources' => 'act_resources'],
        ];
    }
}
