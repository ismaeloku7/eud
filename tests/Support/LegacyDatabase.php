<?php

namespace Tests\Support;

use Illuminate\Support\Facades\DB;
use PDO;

/** Builds a throw-away SQLite copy of the previous site's schema for import tests. */
final class LegacyDatabase
{
    public static function create(): string
    {
        $path = tempnam(sys_get_temp_dir(), 'legacy-').'.sqlite';
        $pdo = new PDO('sqlite:'.$path);

        $schema = preg_replace('/^--.*$/m', '', file_get_contents(base_path('tests/Fixtures/legacy/schema.sql')));

        foreach (array_filter(array_map('trim', explode(";\n", $schema))) as $statement) {
            $pdo->exec($statement);
        }

        config()->set('database.connections.legacy', [
            'driver' => 'sqlite',
            'database' => $path,
            'prefix' => '',
            'foreign_key_constraints' => false,
        ]);
        DB::purge('legacy');

        return $path;
    }

    /** Loads every module of a legacy data file (the JSON seeds of the old repository). */
    public static function loadModules(string ...$files): void
    {
        foreach ($files as $file) {
            foreach (json_decode(file_get_contents(base_path("tests/Fixtures/legacy/{$file}.json")), true) as $module) {
                DB::connection('legacy')->table('modules')->insert([
                    'template' => $module['template'],
                    'name' => $module['name'],
                    'slug' => $module['slug'],
                    'data' => json_encode($module['data'] ?? []),
                    'extras' => json_encode($module['extras'] ?? []),
                ]);
            }
        }
    }
}
