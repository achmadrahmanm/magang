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
        Schema::create('user_signatures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('signature_path')->nullable();
            $table->string('original_filename')->nullable();
            $table->string('file_type')->default('png');
            $table->integer('file_size')->nullable();
            $table->json('signature_data')->nullable(); // Store base64 data as backup
            $table->boolean('is_active')->default(true);
            $table->string('purpose')->nullable(); // e.g., 'proposal', 'document', etc.
            $table->text('notes')->nullable();
            $table->timestamps();
            
            // Indexes
            $table->index(['user_id', 'is_active']);
            $table->index(['user_id', 'purpose']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_signatures');
    }
};