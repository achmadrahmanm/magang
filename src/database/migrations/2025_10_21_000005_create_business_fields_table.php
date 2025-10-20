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
        Schema::create('business_fields', function (Blueprint $table) {
            $table->id();
            
            // Business field information
            $table->string('code', 50)->unique(); // e.g., 'technology', 'finance'
            $table->string('name', 150); // e.g., 'Teknologi Informasi'
            $table->string('name_en', 150)->nullable(); // English name
            $table->text('description')->nullable(); // Detailed description
            $table->string('icon', 50)->nullable(); // Icon class for UI
            $table->string('color', 20)->nullable(); // Color code for UI
            
            // Configuration
            $table->boolean('is_active')->default(true); // Active/inactive status
            $table->integer('sort_order')->default(0); // Display order
            
            // Metadata
            $table->json('metadata')->nullable(); // Additional configuration
            
            $table->timestamps();
            
            // Indexes
            $table->index(['is_active', 'sort_order'], 'business_fields_active_sort_idx');
            $table->index('code');
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('business_fields');
    }
};