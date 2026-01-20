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
        Schema::create('signatures', function (Blueprint $table) {
            $table->id();
            $table->enum('role', ['kepala_sekolah', 'wali_kelas'])->comment('Role of the signature owner');
            $table->string('name')->comment('Name of the official');
            $table->string('nip', 50)->nullable()->comment('NIP of the official');
            $table->string('signature_path')->comment('Path to signature image file');
            $table->boolean('is_active')->default(true)->comment('Whether this signature is currently active');
            $table->timestamps();
            
            // Index for faster queries
            $table->index(['role', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('signatures');
    }
};
