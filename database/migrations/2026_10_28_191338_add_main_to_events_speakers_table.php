<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Marks which speakers of an event are its main speakers (shown in the
     * event intro). Speakers already linked keep appearing there, as before.
     */
    public function up(): void
    {
        Schema::table('events_speakers', function (Blueprint $table) {
            $table->boolean('main')->default(false)->after('speaker_id');
        });

        DB::table('events_speakers')->update(['main' => true]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events_speakers', function (Blueprint $table) {
            $table->dropColumn('main');
        });
    }
};
