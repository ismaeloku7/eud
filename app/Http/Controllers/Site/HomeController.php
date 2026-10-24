<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Page;
use App\Models\Resource;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        return view('site.home', [
            'page' => Page::findBySlug('home') ?? new Page(['sections' => []]),
            'featured' => Resource::query()
                ->where('featured', true)
                ->where('collection', false)
                ->whereHas('files')
                ->with('files.type', 'files.language', 'categories')
                ->latest('updated_at')
                ->take(5)
                ->get(),
            'events' => Event::query()
                ->published()
                ->orderByDesc('date_start')
                ->take(2)
                ->get(),
        ]);
    }
}
