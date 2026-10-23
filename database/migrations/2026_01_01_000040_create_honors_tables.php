<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('honors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ministry_id')->constrained()->cascadeOnDelete();
            $table->foreignId('category_id')->constrained('category_honors')->cascadeOnDelete();
            $table->foreignId('class_id')->nullable()->constrained('class_honors')->nullOnDelete();
            $table->foreignId('level_id')->nullable()->constrained('level_honors')->nullOnDelete();
            $table->foreignId('master_award_id')->nullable()->constrained('master_award_honors')->nullOnDelete();
            $table->json('name');
            $table->json('description')->nullable();
            $table->json('requirements')->nullable();
            $table->string('image')->nullable();
            $table->string('image_secondary')->nullable();
            $table->text('url')->nullable();
            $table->timestamps();
        });

        Schema::create('pdf_honors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('honor_id')->constrained()->cascadeOnDelete();
            $table->foreignId('language_id')->constrained()->cascadeOnDelete();
            $table->json('name')->nullable();
            $table->string('file');
            $table->unsignedBigInteger('size')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pdf_honors');
        Schema::dropIfExists('honors');
    }
};
