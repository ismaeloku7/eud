<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Events keep the same column names as the legacy schema so data can be
 * copied 1:1. Nullability has been relaxed on descriptive columns.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->json('slug');
            $table->json('title');
            $table->json('subtitle')->nullable();
            $table->json('description')->nullable();
            $table->json('type')->nullable();
            $table->json('slogan')->nullable();
            $table->json('quote')->nullable();
            $table->json('tags')->nullable();
            $table->dateTime('date_start');
            $table->dateTime('date_end');
            $table->boolean('publish')->default(false);

            $table->string('photo_portada')->nullable();
            $table->string('facebook_banner')->nullable();
            $table->string('image_about')->nullable();
            $table->string('url_youtube')->nullable();
            $table->string('url_video')->nullable();
            $table->string('playlist_video')->nullable();
            $table->string('url_gallery')->nullable();

            $table->json('location')->nullable();
            $table->string('lat')->nullable();
            $table->string('long')->nullable();
            $table->string('location_url')->nullable();
            $table->json('location_description')->nullable();
            $table->json('location_recursive')->nullable();

            $table->boolean('registration')->default(false);
            $table->json('registration_eud')->nullable();
            $table->json('registration_non_eud')->nullable();
            $table->json('registration_recursive')->nullable();

            // Tab labels / section titles shown on the public event page.
            $table->json('about_tab')->nullable();
            $table->json('speaker_tab')->nullable();
            $table->json('speaker_title')->nullable();
            $table->json('workshop_tab')->nullable();
            $table->json('workshop_title')->nullable();
            $table->json('workshop_description')->nullable();
            $table->json('location_tab')->nullable();
            $table->json('location_title')->nullable();
            $table->json('program_tab')->nullable();
            $table->json('program_title')->nullable();
            $table->json('program_subtitle')->nullable();
            $table->json('program_description')->nullable();
            $table->string('program_image')->nullable();
            $table->string('program_download')->nullable();
            $table->json('gallery_tab')->nullable();
            $table->json('gallery_title')->nullable();
            $table->json('main_session_tab')->nullable();
            $table->json('main_session_title')->nullable();
            $table->json('registration_tab')->nullable();
            $table->json('registration_title')->nullable();

            $table->timestamps();
        });

        Schema::create('speakers', function (Blueprint $table) {
            $table->id();
            $table->json('name');
            $table->json('description')->nullable();
            $table->json('type')->nullable();
            $table->string('photo')->nullable();
            $table->timestamps();
        });

        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->json('name');
            $table->dateTime('date_start');
            $table->dateTime('date_end');
            $table->timestamps();
        });

        Schema::create('localizations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->cascadeOnDelete();
            $table->json('name');
            $table->json('capacity')->nullable();
            $table->timestamps();
        });

        Schema::create('programs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->cascadeOnDelete();
            $table->json('title');
            $table->json('description')->nullable();
            $table->dateTime('date_start');
            $table->dateTime('date_end');
            $table->string('color', 20)->nullable();
            $table->boolean('main_session')->default(false);
            $table->boolean('sync_workshop')->default(false);
            $table->timestamps();
        });

        Schema::create('workshops', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->cascadeOnDelete();
            $table->foreignId('line_id')->nullable()->constrained()->nullOnDelete();
            $table->json('title');
            $table->json('description')->nullable();
            $table->boolean('collection')->default(false);
            $table->string('video_url')->nullable();
            $table->timestamps();
        });

        Schema::create('workshops_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('workshop_id')->constrained()->cascadeOnDelete();
            $table->foreignId('schedule_id')->constrained()->cascadeOnDelete();
            $table->foreignId('localization_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::create('workshops_speakers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('workshop_id')->constrained()->cascadeOnDelete();
            $table->foreignId('speaker_id')->constrained()->cascadeOnDelete();
            $table->unique(['workshop_id', 'speaker_id']);
        });

        Schema::create('programs_speakers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_id')->constrained()->cascadeOnDelete();
            $table->foreignId('speaker_id')->constrained()->cascadeOnDelete();
            $table->unique(['program_id', 'speaker_id']);
        });

        Schema::create('events_speakers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->cascadeOnDelete();
            $table->foreignId('speaker_id')->constrained()->cascadeOnDelete();
            $table->unique(['event_id', 'speaker_id']);
        });

        Schema::create('galleries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->cascadeOnDelete();
            $table->string('image');
            $table->unsignedInteger('position')->default(0);
            $table->timestamps();
        });

        Schema::create('downloads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->cascadeOnDelete();
            $table->json('name');
            $table->string('document');
            $table->string('language', 10)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        foreach (['downloads', 'galleries', 'events_speakers', 'programs_speakers', 'workshops_speakers', 'workshops_schedules', 'workshops', 'programs', 'localizations', 'schedules', 'speakers', 'events'] as $table) {
            Schema::dropIfExists($table);
        }
    }
};
