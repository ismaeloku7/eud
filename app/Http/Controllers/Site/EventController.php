<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Contracts\View\View;

class EventController extends Controller
{
    public function index(): View
    {
        return view('site.events.index', [
            'events' => Event::query()->published()->orderByDesc('date_start')->paginate(9),
        ]);
    }

    public function show(string $slug): View
    {
        $event = Event::query()
            ->published()
            ->whereSlug($slug)
            ->with(['speakers', 'programs.speakers', 'workshops.line', 'workshops.speakers', 'workshops.schedules.schedule', 'workshops.schedules.localization', 'localizations', 'galleries', 'downloads'])
            ->firstOrFail();

        return view('site.events.show', ['event' => $event]);
    }
}
