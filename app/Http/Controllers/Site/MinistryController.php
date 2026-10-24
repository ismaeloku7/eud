<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Ministry;
use App\Models\Page;
use App\Support\Site;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class MinistryController extends Controller
{
    public function __construct(private readonly Site $site) {}

    public function index(): RedirectResponse
    {
        $first = $this->site->ministries()->first() ?? abort(404);

        return redirect()->route('ministries.show', ['slug' => $first->slug]);
    }

    public function show(string $slug, ?string $tab = null): View
    {
        $ministry = Ministry::query()->where('slug', $slug)->firstOrFail();
        $tabs = $this->site->tabs($ministry);
        $default = collect($tabs)->firstWhere('default', true) ?? $tabs[0] ?? null;
        $current = $tab === null ? $default : collect($tabs)->firstWhere('slug', $tab);

        abort_unless($current, 404);

        return view($ministry->slug === 'amicus' ? 'site.ministries.amicus' : 'site.ministries.show', [
            'ministry' => $ministry,
            'page' => Page::findBySlug("ministry-{$ministry->slug}") ?? new Page(['sections' => []]),
            'tabs' => $tabs,
            'tab' => $current['slug'],
        ]);
    }
}
