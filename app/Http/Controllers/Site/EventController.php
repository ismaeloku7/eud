<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class EventController extends Controller
{
    public function index(): View
    {
        return view('site.events.index', [
            'events' => Event::query()->published()->orderByDesc('date_start')->paginate(9),
        ]);
    }

    public function show(string $slug): View|RedirectResponse
    {
        $event = Event::query()
            ->published()
            ->whereSlug($slug)
            ->with(['speakers', 'programs.speakers', 'workshops.line', 'workshops.speakers', 'workshops.schedules.schedule', 'workshops.schedules.localization', 'localizations', 'galleries', 'downloads'])
            ->first();

        if ($event === null) {
            return $this->redirectToLocalizedSlug($slug);
        }

        return view('site.events.show', ['event' => $event]);
    }

    /** A slug of another language (e.g. after switching language) sends the visitor to the right URL. */
    private function redirectToLocalizedSlug(string $slug): RedirectResponse
    {
        $event = Event::query()->published()->get()->first(fn (Event $event) => in_array($slug, $event->getTranslations('slug'), true));

        abort_unless($event && $event->slug, 404);

        return redirect()->route('events.show', ['slug' => $event->slug]);
    }
}
