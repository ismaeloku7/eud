<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Some legacy files point to languages that were deleted; the file itself is
 * still valid, so the language becomes optional instead of losing it.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('files', function (Blueprint $table) {
            $table->dropForeign(['language_id']);
        });

        Schema::table('files', function (Blueprint $table) {
            $table->unsignedBigInteger('language_id')->nullable()->change();
            $table->foreign('language_id')->references('id')->on('languages')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('files', function (Blueprint $table) {
            $table->dropForeign(['language_id']);
        });

        Schema::table('files', function (Blueprint $table) {
            $table->unsignedBigInteger('language_id')->nullable(false)->change();
            $table->foreign('language_id')->references('id')->on('languages')->cascadeOnDelete();
        });
    }
};
