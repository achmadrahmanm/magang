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
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            
            // Foreign key references (nullable for now since these tables might not exist yet)
            $table->unsignedBigInteger('program_id')->nullable();
            $table->unsignedBigInteger('internship_id')->nullable();
            $table->unsignedBigInteger('company_id')->nullable();
            
            // Institution information
            $table->string('institution_name', 191);
            $table->string('institution_address', 255);
            $table->string('business_field', 150);
            $table->string('placement_division', 150);
            
            // Date planning
            $table->date('planned_start_date');
            $table->date('planned_end_date');
            
            // File uploads
            $table->string('purpose_letter_path', 255)->nullable();
            
            // Additional information
            $table->text('notes')->nullable();
            
            // Status management
            $table->enum('status', ['submitted', 'reviewing', 'approved', 'rejected'])->default('submitted');
            $table->text('status_note')->nullable();
            $table->unsignedBigInteger('reviewed_by')->nullable();
            $table->timestamp('reviewed_at')->nullable();
            $table->text('rejection_reason')->nullable();
            
            // Submission tracking
            $table->unsignedBigInteger('submitted_by');
            
            $table->timestamps();
            
            // Foreign key constraints
            $table->foreign('reviewed_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('submitted_by')->references('id')->on('users')->onDelete('cascade');
            
            // Indexes for performance
            $table->index(['program_id', 'status', 'created_at'], 'applications_program_status_created_idx');
            $table->index('reviewed_by');
            $table->index('submitted_by');
            $table->index('status');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};