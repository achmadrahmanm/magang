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
        Schema::table('applications', function (Blueprint $table) {
            // Modify the status enum to include 'draft'
            $table->enum('status', ['draft', 'submitted', 'reviewing', 'approved', 'rejected'])
                  ->default('submitted')
                  ->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            // Revert back to original enum
            $table->enum('status', ['submitted', 'reviewing', 'approved', 'rejected'])
                  ->default('submitted')
                  ->change();
        });
    }
};