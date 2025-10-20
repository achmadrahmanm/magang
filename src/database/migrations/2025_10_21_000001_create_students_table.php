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
        Schema::create('students', function (Blueprint $table) {
            $table->id(); // bigint primary key auto increment
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('nrp', 50)->unique();
            $table->string('nama_resmi', 150);
            $table->string('email_kampus', 191);
            $table->string('prodi', 100);
            $table->string('fakultas', 100);
            $table->string('angkatan', 10);
            $table->integer('semester_berjalan')->nullable();
            $table->integer('sks_total')->nullable();
            $table->enum('status_akademik', ['aktif', 'cuti', 'lulus', 'nonaktif'])->default('aktif');
            $table->timestamps();
            
            // Indexes
            $table->index(['email_kampus']);
            $table->index(['prodi']);
            $table->index(['status_akademik']);
            $table->index(['fakultas']);
            $table->index(['angkatan']);
            $table->index(['user_id', 'status_akademik']); // Composite index for common queries
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};