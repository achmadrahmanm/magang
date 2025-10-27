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
        Schema::create('lecturers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('nip', 50);
            $table->string('nama_resmi', 150);
            $table->string('email_kampus', 191);
            $table->string('prodi', 100);
            $table->string('fakultas', 100);
            $table->string('jabatan', 100);
            $table->timestamps();

            $table->unique('nip');
            $table->index('email_kampus');
            $table->index('prodi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lecturers');
    }
};
