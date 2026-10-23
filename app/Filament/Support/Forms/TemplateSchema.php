<?php

namespace App\Filament\Support\Forms;

use App\Models\Resource;
use App\Pages\Field;
use App\Pages\FieldType;
use App\Pages\Section;
use App\Pages\Template;
use App\Pages\Translate;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;

/**
 * Turns a page template into Filament components: one tab per section,
 * translatable fields with their EN/ES inputs side by side.
 */
class TemplateSchema
{
    /** @return array<int, Component> */
    public static function components(Template $template): array
    {
        return [
            Tabs::make('sections')
                ->tabs(array_map(fn (Section $section) => Tab::make($section->key)
                    ->label($section->label)
                    ->statePath($section->key)
                    ->schema(self::fields($section->fields)), $template->sections()))
                ->persistTabInQueryString('section')
                ->columnSpanFull(),
        ];
    }

    /**
     * @param  array<int, Field>  $fields
     * @return array<int, Component>
     */
    public static function fields(array $fields): array
    {
        return array_map(fn (Field $field) => self::field($field), $fields);
    }

    private static function field(Field $field): Component
    {
        return match ($field->type) {
            FieldType::Text => self::localized($field, fn (string $locale) => TextInput::make("{$field->key}.{$locale}")->maxLength(1000)),
            FieldType::Textarea => self::localized($field, fn (string $locale) => Textarea::make("{$field->key}.{$locale}")->rows(3)),
            FieldType::Rich => self::richTabs($field),
            FieldType::Image => Uploads::image($field->key, 'pages', $field->label)->helperText($field->help),
            FieldType::File => Uploads::document($field->key, 'pages/files', $field->label)->helperText($field->help),
            FieldType::Color => ColorPicker::make($field->key)->label($field->label)->helperText($field->help),
            FieldType::Number => TextInput::make($field->key)->label($field->label)->numeric()->helperText($field->help),
            FieldType::Url => TextInput::make($field->key)->label($field->label)->url()->maxLength(2000)->helperText($field->help),
            FieldType::Resources => Select::make($field->key)
                ->label($field->label)
                ->multiple()
                ->searchable()
                ->options(fn (): array => Resource::query()->get()->mapWithKeys(fn (Resource $resource) => [$resource->id => (string) $resource->title])->sort()->all())
                ->helperText($field->help),
            FieldType::Repeater => Repeater::make($field->key)
                ->label($field->label)
                ->schema(self::fields($field->children))
                ->maxItems($field->max)
                ->defaultItems(0)
                ->collapsible()
                ->reorderable()
                ->itemLabel(fn (array $state): ?string => Translate::resolve($state['title'] ?? $state['name'] ?? null) ?: null)
                ->helperText($field->help)
                ->columnSpanFull(),
        };
    }

    /** @param  callable(string): Component  $input */
    private static function localized(Field $field, callable $input): Component
    {
        $locales = self::locales();

        return Fieldset::make($field->label)
            ->columns(count($locales))
            ->schema(array_map(function (string $locale) use ($input, $field, $locales): Component {
                $component = $input($locale)->label(strtoupper($locale));

                return $locale === $locales[0] && $field->help ? $component->helperText($field->help) : $component;
            }, $locales));
    }

    private static function richTabs(Field $field): Component
    {
        return Tabs::make($field->key)
            ->tabs(array_map(fn (string $locale) => Tab::make("{$field->key}-{$locale}")
                ->label("{$field->label} (".strtoupper($locale).')')
                ->schema([
                    RichEditor::make("{$field->key}.{$locale}")
                        ->hiddenLabel()
                        ->toolbarButtons(['bold', 'italic', 'underline', 'link', 'bulletList', 'orderedList', 'h2', 'h3', 'blockquote', 'undo', 'redo'])
                        ->helperText($field->help),
                ]), self::locales()))
            ->contained(false)
            ->columnSpanFull();
    }

    /** @return array<int, string> */
    private static function locales(): array
    {
        return config('app.supported_locales');
    }
}
