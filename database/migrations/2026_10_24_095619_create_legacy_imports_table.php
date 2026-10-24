<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/** One row per finished import of the previous site, so deploys import only once. */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('legacy_imports', function (Blueprint $table) {
            $table->id();
            $table->string('source');
            $table->unsignedInteger('files_copied')->default(0);
            $table->unsignedInteger('files_missing')->default(0);
            $table->unsignedInteger('warnings')->default(0);
            $table->json('missing')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('legacy_imports');
    }
};
