<?php

namespace Database\Seeders;

use App\Models\Ministry;
use App\Models\Page;
use Illuminate\Database\Seeder;

/** Creates the fixed pages the public site expects; never overwrites edited content. */
class PageSeeder extends Seeder
{
    public function run(): void
    {
        $pages = [
            ['slug' => 'global', 'template' => 'global', 'name' => 'Site settings'],
            ['slug' => 'home', 'template' => 'home', 'name' => 'Home'],
            ['slug' => 'about', 'template' => 'about', 'name' => 'About us'],
            ['slug' => 'mission', 'template' => 'mission', 'name' => 'Mission'],
        ];

        foreach (Ministry::query()->orderBy('position')->get() as $ministry) {
            $pages[] = [
                'slug' => "ministry-{$ministry->slug}",
                'template' => $ministry->slug === 'amicus' ? 'amicus' : 'ministry',
                'name' => 'Ministry: '.$ministry->getTranslation('name', 'en'),
            ];
        }

        foreach ($pages as $page) {
            Page::firstOrCreate(['slug' => $page['slug']], [
                'template' => $page['template'],
                'name' => $page['name'],
                'title' => ['en' => $page['name']],
                'sections' => [],
                'published' => true,
            ]);
        }
    }
}
