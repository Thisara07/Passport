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
        // Since we can't easily modify the primary key, let's recreate it properly
        DB::statement('ALTER TABLE time_slots MODIFY Slot_ID INT AUTO_INCREMENT PRIMARY KEY;');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('ALTER TABLE time_slots MODIFY Slot_ID INT NOT NULL;');
    }
};
