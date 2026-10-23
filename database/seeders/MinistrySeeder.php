<?php

namespace Database\Seeders;

use App\Models\Ministry;
use Illuminate\Database\Seeder;

class MinistrySeeder extends Seeder
{
    public function run(): void
    {
        $ministries = [
            ['slug' => 'cachorros', 'name' => ['en' => 'Cachorros', 'es' => 'Cachorros']],
            ['slug' => 'adventurers', 'name' => ['en' => 'Adventurers', 'es' => 'Aventureros']],
            ['slug' => 'pathfinders', 'name' => ['en' => 'Pathfinders', 'es' => 'Conquistadores']],
            ['slug' => 'ambassadors', 'name' => ['en' => 'Ambassadors', 'es' => 'Embajadores']],
            ['slug' => 'young-adults', 'name' => ['en' => 'Young Adults', 'es' => 'Jóvenes adultos']],
            ['slug' => 'amicus', 'name' => ['en' => 'AMiCUS', 'es' => 'AMiCUS']],
        ];

        foreach ($ministries as $position => $ministry) {
            Ministry::updateOrCreate(
                ['slug' => $ministry['slug']],
                ['name' => $ministry['name'], 'position' => $position + 1],
            );
        }
    }
}
