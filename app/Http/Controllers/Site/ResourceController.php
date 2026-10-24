<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\File;
use App\Models\Resource;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class ResourceController extends Controller
{
    public function index(): View
    {
        return view('site.resources.index');
    }

    public function show(string $slug): View
    {
        $resource = Resource::query()
            ->where('slug', $slug)
            ->with(['files.type', 'files.language', 'categories', 'ministries', 'related.files', 'items.files.type', 'items.files.language', 'items.categories'])
            ->firstOrFail();

        return view('site.resources.show', ['resource' => $resource]);
    }

    /** Counts the download and sends the visitor to the file. */
    public function download(Resource $resource, File $file): RedirectResponse
    {
        abort_unless($file->model_type === Resource::class && $file->model_id === $resource->id, 404);

        $resource->increment('quantity');

        $url = $file->url ?: ($file->file ? Storage::disk('public')->url($file->file) : null);

        abort_unless($url, 404);

        return redirect()->away($url);
    }
}
