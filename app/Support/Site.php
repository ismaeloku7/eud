<?php

namespace App\Support;

use App\Models\Ministry;
use App\Models\Page;
use App\Pages\SectionData;
use Illuminate\Support\Collection;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/**
 * Data every public page needs: site settings (the "global" page),
 * the ministries menu and the language switcher. Shared with views as $site.
 */
class Site
{
    private ?Page $settings = null;

    private ?Collection $ministries = null;

    /** A section of the site settings page (navigation, brand, contact, ministries). */
    public function settings(string $section): SectionData
    {
        $this->settings ??= Page::findBySlug('global') ?? new Page(['sections' => []]);

        return $this->settings->section($section);
    }

    /** @return Collection<int, Ministry> ordered as shown in menus */
    public function ministries(): Collection
    {
        $rows = cache()->rememberForever('site:ministries', fn () => Ministry::query()->orderBy('position')->orderBy('id')->get()->map->getAttributes()->all());

        return $this->ministries ??= Ministry::query()->hydrate($rows);
    }

    /** @return array<int, array{slug: string, name: string, default?: bool}> */
    public function tabs(Ministry $ministry): array
    {
        return config("site.ministries.{$ministry->slug}.tabs", []);
    }

    public function logo(Ministry $ministry): string
    {
        return asset(config("site.ministries.{$ministry->slug}.logo", 'images/Logo.svg'));
    }

    /** Name shown in menus (AMiCUS keeps its own spelling). */
    public function menuName(Ministry $ministry): string
    {
        return config("site.ministries.{$ministry->slug}.menu_name") ?? ucwords(strtolower((string) $ministry->name));
    }

    public function tabUrl(Ministry $ministry, array $tab): string
    {
        return ($tab['default'] ?? false)
            ? route('ministries.show', ['slug' => $ministry->slug])
            : route('ministries_tab.show', ['slug' => $ministry->slug, 'tab' => $tab['slug']]);
    }

    /** @return array<int, array{code: string, url: string, selected: bool}> */
    public function languages(): array
    {
        $languages = [];

        foreach (LaravelLocalization::getSupportedLocales() as $code => $properties) {
            $languages[] = [
                'code' => $code,
                'url' => LaravelLocalization::getLocalizedURL($code, null, [], true),
                'selected' => $code === LaravelLocalization::getCurrentLocale(),
            ];
        }

        return $languages;
    }
}
