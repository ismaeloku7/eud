<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Replaces the legacy pages + modules + attributes trio. Every page follows a
 * template (App\Pages\Templates) that declares its sections and fields with
 * human readable labels; the editor fills them in on one screen and the
 * values live in the `sections` JSON column.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('template');
            $table->json('title')->nullable();
            $table->json('sections')->nullable();
            $table->json('seo')->nullable();
            $table->boolean('published')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};
