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
        Schema::create('logs_absensis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('absensi_id')->constrained('absensis');
            $table->foreignId('siswa_id')->constrained('siswas');
            $table->foreignId('guru_piket_id')->constrained('users');
            $table->enum('status_lama', ['hadir', 'sakit', 'izin', 'alpa']);
            $table->enum('status_baru', ['hadir', 'sakit', 'izin', 'alpa']);
            $table->string('keterangan_lama')->nullable();
            $table->string('keterangan_baru')->nullable();
            $table->timestamp('waktu_edit');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logs_absensis');
    }
};
