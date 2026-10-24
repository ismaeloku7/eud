<?php

use App\Legacy\EventScoping;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/** Time slots and workshop tracks are configured inside each event instead of as shared lists. */
return new class extends Migration
{
    public function up(): void
    {
        foreach (['schedules', 'lines'] as $table) {
            Schema::table($table, function (Blueprint $blueprint) {
                $blueprint->foreignId('event_id')->nullable()->after('id')->constrained()->cascadeOnDelete();
            });
        }

        EventScoping::assign();
    }

    public function down(): void
    {
        foreach (['schedules', 'lines'] as $table) {
            Schema::table($table, function (Blueprint $blueprint) {
                $blueprint->dropConstrainedForeignId('event_id');
            });
        }
    }
};
