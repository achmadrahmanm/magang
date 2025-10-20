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
        Schema::create('application_members', function (Blueprint $table) {
            $table->id();
            
            // Foreign key references
            $table->unsignedBigInteger('application_id');
            $table->unsignedBigInteger('student_id');
            
            // Member role
            $table->enum('role', ['leader', 'member'])->default('member');
            
            // Additional information
            $table->text('notes')->nullable();
            $table->timestamp('joined_at')->useCurrent();
            
            $table->timestamps();
            
            // Foreign key constraints
            $table->foreign('application_id')->references('id')->on('applications')->onDelete('cascade');
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
            
            // Unique constraint to prevent duplicate student in same application
            $table->unique(['application_id', 'student_id'], 'application_members_app_student_unique');
            
            // Indexes for performance
            $table->index('student_id');
            $table->index('role');
            $table->index('joined_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('application_members');
    }
};