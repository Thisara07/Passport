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
        // Fix for missing AUTO_INCREMENT on primary keys
        // We use raw SQL because modifying existing primary keys to AUTO_INCREMENT 
        // can be tricky via standard Blueprint methods depending on the current state.
        
        DB::statement('ALTER TABLE documents MODIFY Document_ID INT AUTO_INCREMENT PRIMARY KEY;');
        DB::statement('ALTER TABLE application MODIFY Application_ID INT AUTO_INCREMENT PRIMARY KEY;');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('ALTER TABLE application MODIFY Application_ID INT NOT NULL;');
        DB::statement('ALTER TABLE documents MODIFY Document_ID INT NOT NULL;');
    }
};
