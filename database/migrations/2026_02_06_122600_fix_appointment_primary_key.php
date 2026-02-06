<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Fix for "Field 'Appointment_ID' doesn't have a default value" error
        // Re-defining the primary key with AUTO_INCREMENT
        DB::statement('ALTER TABLE appointment MODIFY Appointment_ID INT AUTO_INCREMENT PRIMARY KEY;');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('ALTER TABLE appointment MODIFY Appointment_ID INT NOT NULL;');
    }
};
