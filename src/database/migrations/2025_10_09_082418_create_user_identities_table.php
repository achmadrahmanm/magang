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
        Schema::create('user_identities', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->unique(); // Custom user ID (e.g., 2021001234)
            $table->string('email')->unique(); // Foreign key to users table
            $table->string('campus_id')->nullable();
            $table->string('department')->nullable();
            $table->string('major')->nullable();
            $table->string('name');
            $table->enum('gender', ['male', 'female'])->nullable();
            $table->date('dob')->nullable(); // Date of birth
            $table->string('phone')->nullable();
            $table->string('image')->nullable(); // Profile image path
            $table->date('join_date')->nullable();
            $table->integer('sks_score')->default(0); // Credit score
            $table->timestamps();
            $table->softDeletes(); // deleted_at

            // Foreign key constraint
            $table->foreign('email')->references('email')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_identities');
    }
};
