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
        // Add timestamps to all relevant tables
        Schema::table('admin', function (Blueprint $table) {
            $table->timestamps();
        });
        
        Schema::table('applicant', function (Blueprint $table) {
            $table->timestamps();
        });
        
        Schema::table('appointment', function (Blueprint $table) {
            $table->timestamps();
        });
        
        Schema::table('officer', function (Blueprint $table) {
            $table->timestamps();
        });
        
        Schema::table('passport', function (Blueprint $table) {
            $table->timestamps();
        });
        
        Schema::table('payment', function (Blueprint $table) {
            $table->timestamps();
        });
        
        Schema::table('time_slots', function (Blueprint $table) {
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('admin', function (Blueprint $table) {
            $table->dropTimestamps();
        });
        
        Schema::table('applicant', function (Blueprint $table) {
            $table->dropTimestamps();
        });
        
        Schema::table('appointment', function (Blueprint $table) {
            $table->dropTimestamps();
        });
        
        Schema::table('officer', function (Blueprint $table) {
            $table->dropTimestamps();
        });
        
        Schema::table('passport', function (Blueprint $table) {
            $table->dropTimestamps();
        });
        
        Schema::table('payment', function (Blueprint $table) {
            $table->dropTimestamps();
        });
        
        Schema::table('time_slots', function (Blueprint $table) {
            $table->dropTimestamps();
        });
    }
};
