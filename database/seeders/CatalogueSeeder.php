<?php

namespace Database\Seeders;

use App\Models\CategoryHonor;
use App\Models\CategoryResource;
use App\Models\ClassHonor;
use App\Models\Language;
use App\Models\LevelHonor;
use App\Models\MasterAwardHonor;
use App\Models\TypeDirector;
use App\Models\TypeFile;
use Illuminate\Database\Seeder;

/**
 * Baseline catalogue values. Safe to re-run: every row is matched by its
 * English name. Production data comes from the legacy database import.
 */
class CatalogueSeeder extends Seeder
{
    public function run(): void
    {
        foreach ([
            'en' => ['en' => 'English', 'es' => 'Inglés'],
            'es' => ['en' => 'Spanish', 'es' => 'Español'],
            'fr' => ['en' => 'French', 'es' => 'Francés'],
            'de' => ['en' => 'German', 'es' => 'Alemán'],
            'it' => ['en' => 'Italian', 'es' => 'Italiano'],
            'pt' => ['en' => 'Portuguese', 'es' => 'Portugués'],
            'ro' => ['en' => 'Romanian', 'es' => 'Rumano'],
        ] as $code => $name) {
            Language::updateOrCreate(['code' => $code], ['name' => $name]);
        }

        foreach (['PDF', 'MP3', 'MP4', 'PNG', 'JPG', 'ZIP', 'DOCX', 'PPTX'] as $type) {
            TypeFile::firstOrCreate(['name' => $type]);
        }

        $this->seedTranslatable(TypeDirector::class, [
            ['en' => 'Youth Director', 'es' => 'Director de Jóvenes'],
            ['en' => 'Pathfinder Director', 'es' => 'Director de Conquistadores'],
        ]);

        $this->seedTranslatable(CategoryHonor::class, [
            ['en' => 'ADRA', 'es' => 'ADRA'],
            ['en' => 'Arts, Crafts & Hobbies', 'es' => 'Artes, manualidades y aficiones'],
            ['en' => 'Health & Science', 'es' => 'Salud y ciencia'],
            ['en' => 'Household Arts', 'es' => 'Artes domésticas'],
            ['en' => 'Nature', 'es' => 'Naturaleza'],
            ['en' => 'Outdoor Industries', 'es' => 'Actividades al aire libre'],
            ['en' => 'Recreation', 'es' => 'Recreación'],
            ['en' => 'Spiritual Growth, Outreach & Heritage', 'es' => 'Crecimiento espiritual, misión y herencia'],
            ['en' => 'Vocational', 'es' => 'Vocacional'],
        ], ['color' => '#6847c3']);

        $this->seedTranslatable(ClassHonor::class, [
            ['en' => 'Not required', 'es' => 'No requerido'],
        ]);

        $this->seedTranslatable(LevelHonor::class, [
            ['en' => 'Level 1', 'es' => 'Nivel 1'],
            ['en' => 'Level 2', 'es' => 'Nivel 2'],
            ['en' => 'Level 3', 'es' => 'Nivel 3'],
            ['en' => 'Advanced', 'es' => 'Avanzado'],
        ]);

        $this->seedTranslatable(MasterAwardHonor::class, [
            ['en' => 'Not required', 'es' => 'No requerido'],
            ['en' => 'Artisan', 'es' => 'Artesano'],
        ]);

        $this->seedTranslatable(CategoryResource::class, [
            ['en' => 'Church', 'es' => 'Iglesia'],
            ['en' => 'AMiCUS Students', 'es' => 'Estudiantes AMiCUS'],
            ['en' => 'Young Adults', 'es' => 'Jóvenes adultos'],
            ['en' => 'Ambassadors', 'es' => 'Embajadores'],
        ]);
    }

    /** @param  array<int, array<string, string>>  $names */
    private function seedTranslatable(string $model, array $names, array $extra = []): void
    {
        foreach ($names as $name) {
            $existing = $model::query()->where('name->en', $name['en'])->first();

            if ($existing) {
                $existing->setTranslations('name', $name)->save();

                continue;
            }

            $model::create(['name' => $name, ...$extra]);
        }
    }
}
