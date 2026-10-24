<?php

namespace App\Filament\Widgets;

use App\Console\Commands\SiteSetupCommand;
use App\Models\Event;
use App\Models\Honor;
use App\Models\Page;
use App\Models\Resource;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

/** Dashboard summary of the content and of the one-time import of the previous site. */
class ContentStatus extends StatsOverviewWidget
{
    protected static ?int $sort = -1;

    protected static bool $isLazy = false;

    protected int|string|array $columnSpan = 'full';

    protected function getHeading(): ?string
    {
        return __('Content');
    }

    protected function getStats(): array
    {
        $import = DB::table('legacy_imports')->latest('id')->first();
        $pagesWithContent = Page::query()->get()->filter(fn (Page $page): bool => collect($page->sections ?? [])->flatten()->filter()->isNotEmpty())->count();

        return [
            Stat::make(__('Import of the previous site'), $import ? __('Done') : __('Not done'))
                ->description($import
                    ? __(':date · :copied files copied · :missing pending download', ['date' => Carbon::parse($import->created_at)->format('d/m/Y H:i'), 'copied' => $import->files_copied, 'missing' => $import->files_missing])
                    : (File::exists(base_path(SiteSetupCommand::BUNDLED_DUMP)) ? __('Pending: runs on the next deploy') : __('No data file in this version')))
                ->color($import ? ($import->files_missing > 0 ? 'warning' : 'success') : 'danger'),
            Stat::make(__('Resources'), Resource::count()),
            Stat::make(__('Honors'), Honor::count()),
            Stat::make(__('Events'), Event::count()),
            Stat::make(__('Pages with content'), $pagesWithContent.' / '.Page::count()),
        ];
    }
}
