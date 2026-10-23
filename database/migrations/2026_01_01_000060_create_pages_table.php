<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Replaces the legacy pages + modules + attributes trio. A page is an ordered
 * list of typed blocks stored as JSON; every block has a human readable label
 * in the admin instead of title_1 / content_2 style field names.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->json('title')->nullable();
            $table->json('blocks')->nullable();
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
