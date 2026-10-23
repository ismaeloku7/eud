<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Catalogue tables: small lists the editor maintains and the rest of the
 * content points to. Translatable columns are JSON (spatie/laravel-translatable).
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->json('name');
            $table->string('image')->nullable();
            $table->foreignId('country_id')->nullable()->constrained('countries')->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('languages', function (Blueprint $table) {
            $table->id();
            $table->json('name');
            $table->string('code', 10)->nullable()->unique();
            $table->timestamps();
        });

        Schema::create('type_files', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('type_directors', function (Blueprint $table) {
            $table->id();
            $table->json('name');
            $table->timestamps();
        });

        Schema::create('category_honors', function (Blueprint $table) {
            $table->id();
            $table->json('name');
            $table->string('color', 20)->default('#6847c3');
            $table->unsignedInteger('position')->default(0);
            $table->timestamps();
        });

        Schema::create('class_honors', function (Blueprint $table) {
            $table->id();
            $table->json('name');
            $table->timestamps();
        });

        Schema::create('level_honors', function (Blueprint $table) {
            $table->id();
            $table->json('name');
            $table->timestamps();
        });

        Schema::create('master_award_honors', function (Blueprint $table) {
            $table->id();
            $table->json('name');
            $table->timestamps();
        });

        Schema::create('category_resources', function (Blueprint $table) {
            $table->id();
            $table->json('name');
            $table->timestamps();
        });

        Schema::create('lines', function (Blueprint $table) {
            $table->id();
            $table->json('title');
            $table->json('description')->nullable();
            $table->string('color', 20)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        foreach (['lines', 'category_resources', 'master_award_honors', 'level_honors', 'class_honors', 'category_honors', 'type_directors', 'type_files', 'languages', 'countries'] as $table) {
            Schema::dropIfExists($table);
        }
    }
};
