<?php

namespace App\Legacy\Steps;

use App\Legacy\Json;
use App\Legacy\LegacyContext;
use App\Legacy\ModuleMap;
use App\Models\Ministry;
use App\Models\Page;
use App\Pages\Field;
use App\Pages\FieldType;
use App\Pages\Templates;
use Database\Seeders\PageSeeder;

/**
 * Turns legacy modules and the AMiCUS attribute blob into page sections.
 * Values are normalised through the template field types, so the mapping
 * only has to say which legacy key feeds which new field.
 */
class PagesStep implements ImportStep
{
    /** @var array<string, array<string, array<string, mixed>>> page slug => sections */
    private array $sections = [];

    /** @var array<string, array<string, array<string, array<int, array<string, mixed>>>>> page slug => section => list => [index => item] */
    private array $lists = [];

    public static function name(): string
    {
        return 'pages';
    }

    public function run(LegacyContext $context): void
    {
        (new PageSeeder)->run();

        $ministries = Ministry::query()->pluck('slug', 'id');

        foreach ($context->legacy->table('modules')->whereNull('deleted_at')->orderBy('id')->get() as $module) {
            $this->importModule((array) $module, $ministries->all(), $context);
        }

        $this->importAmicus($context);

        foreach ($this->sections as $slug => $sections) {
            foreach ($this->lists[$slug] ?? [] as $section => $lists) {
                foreach ($lists as $list => $items) {
                    ksort($items);
                    $sections[$section][$list] = array_values($items);
                }
            }

            $page = Page::query()->where('slug', $slug)->first();

            if (! $page) {
                $context->warn("No page with slug [{$slug}] to receive legacy content.");

                continue;
            }

            $page->update(['sections' => array_replace($page->sections ?? [], $sections)]);
            $context->info(sprintf('%-32s %5d sections', "page:{$slug}", count($sections)));
        }
    }

    /**
     * @param  array<string, mixed>  $module
     * @param  array<int, string>  $ministries  legacy id => slug
     */
    private function importModule(array $module, array $ministries, LegacyContext $context): void
    {
        $slug = (string) $module['slug'];
        $values = [...(Json::list($module['extras']) ?? []), ...(Json::list($module['data']) ?? [])];

        if (preg_match('/^ministry-(\d+)-general-section-(.+)$/', $slug, $match)) {
            if (! isset($ministries[(int) $match[1]])) {
                $context->warn("Module [{$slug}] belongs to an unknown ministry, skipped.");

                return;
            }

            $this->apply('ministry', 'ministry-'.$ministries[(int) $match[1]], $match[2], $values, $context);

            return;
        }

        $template = match (true) {
            str_starts_with($slug, 'home') => 'home',
            str_starts_with($slug, 'about') => 'about',
            $slug === 'mission' => 'mission',
            str_starts_with($slug, 'global-'), str_starts_with($slug, 'ministry-general-') => 'global',
            default => null,
        };

        if ($template === null) {
            $context->warn("Module [{$slug}] does not match any page, skipped.");

            return;
        }

        $this->apply($template, $template === 'global' ? 'global' : $template, $slug, $values, $context);
    }

    /** @param  array<string, mixed>  $values */
    private function apply(string $template, string $pageSlug, string $key, array $values, LegacyContext $context): void
    {
        foreach (ModuleMap::rules($template) as $rule) {
            if (! preg_match($rule['pattern'], $key, $match)) {
                continue;
            }

            $section = Templates::find($template)->section($rule['section']);

            if ($section === null || ! $this->pageHasSection($pageSlug, $rule['section'])) {
                return;
            }

            $item = [];

            foreach ($rule['fields'] as $target => $source) {
                $field = $this->field($section?->fields ?? [], $target, $rule['list'] ?? null);

                if ($field && array_key_exists($source, $values)) {
                    $item[$target] = $this->normalise($field, $values[$source], $context);
                }
            }

            if (isset($rule['list'])) {
                $this->lists[$pageSlug][$rule['section']][$rule['list']][(int) ($match[1] ?? 0)] = $item;
            } else {
                $this->sections[$pageSlug][$rule['section']] = [...($this->sections[$pageSlug][$rule['section']] ?? []), ...$item];
            }

            $this->sections[$pageSlug][$rule['section']] ??= [];

            return;
        }

        $context->warn("Module [{$key}] of template [{$template}] has no mapping, skipped.");
    }

    /** Pages keep only the sections their own template declares (AMiCUS ignores the generic ministry modules). */
    private function pageHasSection(string $pageSlug, string $section): bool
    {
        $page = Page::query()->where('slug', $pageSlug)->first();

        return $page === null || Templates::find($page->template)->section($section) !== null;
    }

    private function importAmicus(LegacyContext $context): void
    {
        $attribute = $context->legacy->table('attributes')->where('key', 'amicus')->whereNull('deleted_at')->first();

        if (! $attribute) {
            return;
        }

        $values = Json::list($attribute->value) ?? [];
        $template = Templates::find('amicus');

        foreach (ModuleMap::amicus() as $sectionKey => $fields) {
            $section = $template->section($sectionKey);

            foreach ($fields as $target => $source) {
                $field = $this->field($section?->fields ?? [], $target);

                if ($field && array_key_exists($source, $values)) {
                    $this->sections['ministry-amicus'][$sectionKey][$target] = $this->normalise($field, $values[$source], $context);
                }
            }
        }
    }

    /** @param  array<int, Field>  $fields */
    private function field(array $fields, string $key, ?string $list = null): ?Field
    {
        foreach ($fields as $field) {
            if ($list !== null && $field->key === $list) {
                return $this->field($field->children, $key);
            }

            if ($list === null && $field->key === $key) {
                return $field;
            }
        }

        return null;
    }

    private function normalise(Field $field, mixed $raw, LegacyContext $context): mixed
    {
        return match ($field->type) {
            FieldType::Text, FieldType::Textarea, FieldType::Rich => Json::translatable($raw),
            FieldType::Image, FieldType::File => $context->files->path($raw),
            FieldType::Number => Json::int($raw),
            FieldType::Color, FieldType::Url => is_string($raw) && $raw !== '' ? $raw : null,
            FieldType::Resources => array_values(array_filter(array_map(
                fn ($entry) => Json::int(is_array($entry) ? ($entry['id'] ?? null) : $entry),
                Json::list($raw) ?? [],
            ))),
            FieldType::Repeater => array_values(array_map(function ($entry) use ($field, $context): array {
                $item = [];

                foreach ($field->children as $child) {
                    if (is_array($entry) && array_key_exists($child->key, $entry)) {
                        $item[$child->key] = $this->normalise($child, $entry[$child->key], $context);
                    }
                }

                return $item;
            }, Json::list($raw) ?? [])),
        };
    }
}
