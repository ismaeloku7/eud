<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Contracts\View\View;

/** Static pages whose content comes from the page editor. */
class PageController extends Controller
{
    public function about(): View
    {
        return view('site.about', ['page' => $this->page('about')]);
    }

    public function mission(): View
    {
        return view('site.mission', ['page' => $this->page('mission')]);
    }

    public function contact(): View
    {
        return view('site.contact', ['page' => $this->page('home')]);
    }

    private function page(string $slug): Page
    {
        return Page::findBySlug($slug) ?? abort(404);
    }
}
