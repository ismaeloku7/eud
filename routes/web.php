<?php

use App\Http\Controllers\Site\EventController;
use App\Http\Controllers\Site\HomeController;
use App\Http\Controllers\Site\MinistryController;
use App\Http\Controllers\Site\PageController;
use App\Http\Controllers\Site\ResourceController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/*
| Public site. URLs are translated per locale (lang/{locale}/routes.php);
| English has no prefix, Spanish lives under /es.
*/
Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['localize', 'localeSessionRedirect', 'localizationRedirect'],
], function (): void {
    Route::get('/', HomeController::class)->name('home');

    Route::get(LaravelLocalization::transRoute('routes.about'), [PageController::class, 'about'])->name('about');
    Route::get(LaravelLocalization::transRoute('routes.mission'), [PageController::class, 'mission'])->name('mission');
    Route::get(LaravelLocalization::transRoute('routes.contact'), [PageController::class, 'contact'])->name('contact');

    Route::get(LaravelLocalization::transRoute('routes.events.index'), [EventController::class, 'index'])->name('events.index');
    Route::get(LaravelLocalization::transRoute('routes.events.show'), [EventController::class, 'show'])->name('events.show');

    Route::get(LaravelLocalization::transRoute('routes.resources.index'), [ResourceController::class, 'index'])->name('resources.index');
    Route::get(LaravelLocalization::transRoute('routes.resources.show'), [ResourceController::class, 'show'])->name('resources.show');

    Route::get(LaravelLocalization::transRoute('routes.ministries.index'), [MinistryController::class, 'index'])->name('ministries.index');
    Route::get(LaravelLocalization::transRoute('routes.ministries.show'), [MinistryController::class, 'show'])->name('ministries.show');
    Route::get(LaravelLocalization::transRoute('routes.ministries_tab.show'), [MinistryController::class, 'show'])->name('ministries_tab.show');
});

Route::post('resources/{resource}/files/{file}/download', [ResourceController::class, 'download'])->name('resources.download');
