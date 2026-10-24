<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * The first production deploy created `pages` with the early schema (a
 * `blocks` column and no `template`). Brings that table to the template
 * schema; on databases created later it finds nothing to change.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('pages', 'template')) {
            Schema::table('pages', function (Blueprint $table) {
                $table->string('template')->default('')->after('slug');
            });
        }

        if (Schema::hasColumn('pages', 'blocks') && ! Schema::hasColumn('pages', 'sections')) {
            Schema::table('pages', function (Blueprint $table) {
                $table->renameColumn('blocks', 'sections');
            });
        }

        if (! Schema::hasColumn('pages', 'sections')) {
            Schema::table('pages', function (Blueprint $table) {
                $table->json('sections')->nullable();
            });
        }
    }

    public function down(): void
    {
        //
    }
};
