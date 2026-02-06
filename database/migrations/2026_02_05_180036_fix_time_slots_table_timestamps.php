<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add timestamps to time_slots table if they don't exist
        if (!Schema::hasColumn('time_slots', 'created_at') || !Schema::hasColumn('time_slots', 'updated_at')) {
            Schema::table('time_slots', function (Blueprint $table) {
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('time_slots', function (Blueprint $table) {
            $table->dropTimestamps();
        });
    }
};
