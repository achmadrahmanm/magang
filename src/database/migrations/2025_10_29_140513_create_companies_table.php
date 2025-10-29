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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name', 191);
            $table->string('address', 255);
            $table->string('business_field', 150);
            $table->text('placement_divisions');
            $table->string('website', 191);
            $table->boolean('is_verified')->default(false);
            $table->enum('status', ['active', 'blacklisted', 'inactive'])->default('active');
            $table->enum('source', ['campus', 'student', 'partner'])->default('campus');
            $table->text('notes');
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();

            $table->unique('name');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
