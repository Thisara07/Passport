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
        // Add timestamps to application table
        Schema::table('application', function (Blueprint $table) {
            $table->timestamps();
        });
        
        // Add timestamps to documents table
        Schema::table('documents', function (Blueprint $table) {
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('application', function (Blueprint $table) {
            $table->dropTimestamps();
        });
        
        Schema::table('documents', function (Blueprint $table) {
            $table->dropTimestamps();
        });
    }
};
