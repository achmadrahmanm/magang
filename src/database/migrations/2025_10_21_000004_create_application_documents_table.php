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
        Schema::create('application_documents', function (Blueprint $table) {
            $table->id();
            
            // Foreign key reference to applications
            $table->unsignedBigInteger('application_id');
            
            // Document information
            $table->string('document_type', 100); // e.g., 'purpose_letter', 'cv', 'transcript', etc.
            $table->string('document_name', 255); // Original filename
            $table->string('file_path', 500); // Path to stored file
            $table->string('mime_type', 100); // File MIME type
            $table->unsignedBigInteger('file_size'); // File size in bytes
            
            // Document metadata
            $table->text('description')->nullable(); // Optional description
            $table->boolean('is_required')->default(false); // Whether this document is required
            $table->boolean('is_verified')->default(false); // Whether document has been verified
            $table->unsignedBigInteger('verified_by')->nullable(); // Who verified the document
            $table->timestamp('verified_at')->nullable(); // When document was verified
            
            // Upload tracking
            $table->unsignedBigInteger('uploaded_by'); // Who uploaded the document
            
            $table->timestamps();
            
            // Foreign key constraints
            $table->foreign('application_id')->references('id')->on('applications')->onDelete('cascade');
            $table->foreign('uploaded_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('verified_by')->references('id')->on('users')->onDelete('set null');
            
            // Indexes for performance
            $table->index(['application_id', 'document_type'], 'app_docs_app_type_idx');
            $table->index('uploaded_by');
            $table->index('verified_by');
            $table->index('is_required');
            $table->index('is_verified');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('application_documents');
    }
};