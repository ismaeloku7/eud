<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('resources', function (Blueprint $table) {
            $table->id();
            $table->json('title');
            $table->json('subtitle')->nullable();
            $table->json('intro')->nullable();
            $table->json('description')->nullable();
            $table->json('legend')->nullable();
            $table->json('pages')->nullable();
            $table->string('slug')->unique();
            $table->string('author')->nullable();
            $table->string('image')->nullable();
            $table->boolean('collection')->default(false);
            $table->boolean('featured')->default(false);
            $table->unsignedBigInteger('quantity')->default(0);
            $table->timestamps();
        });

        Schema::create('ministry_resources', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ministry_id')->constrained()->cascadeOnDelete();
            $table->foreignId('resource_id')->constrained()->cascadeOnDelete();
            $table->unique(['ministry_id', 'resource_id']);
        });

        Schema::create('category_resource_resources', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('category_resources')->cascadeOnDelete();
            $table->foreignId('resource_id')->constrained()->cascadeOnDelete();
            $table->unique(['category_id', 'resource_id']);
        });

        // A "collection" resource groups other resources (project_id is the collection).
        Schema::create('project_resources', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('resources')->cascadeOnDelete();
            $table->foreignId('resource_id')->constrained()->cascadeOnDelete();
            $table->unsignedInteger('position')->default(0);
            $table->unique(['project_id', 'resource_id']);
        });

        Schema::create('related_resources', function (Blueprint $table) {
            $table->id();
            $table->foreignId('resource_id')->constrained()->cascadeOnDelete();
            $table->foreignId('related_id')->constrained('resources')->cascadeOnDelete();
            $table->unique(['resource_id', 'related_id']);
        });

        // Downloadable files attached to any model (resources today).
        Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->morphs('model');
            $table->foreignId('language_id')->constrained()->cascadeOnDelete();
            $table->foreignId('type_file_id')->nullable()->constrained('type_files')->nullOnDelete();
            $table->string('file')->nullable();
            $table->text('url')->nullable();
            $table->unsignedBigInteger('size')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        foreach (['files', 'related_resources', 'project_resources', 'category_resource_resources', 'ministry_resources', 'resources'] as $table) {
            Schema::dropIfExists($table);
        }
    }
};
