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
        Schema::create('sertifikasi', function (Blueprint $table) {
            $table->uuid('id')->primary(); // Primary Key
            $table->uuid('id_anggota'); // Foreign Key
            $table->string('sertifikasi');
            $table->year('tahun');
            $table->string('penyelenggara');
            $table->enum('tingkat', ['Internasional', 'Nasional', 'Provinsi', 'Daerah', 'Cabang']);
            $table->string('dokumen_sertifikasi')->nullable();
            $table->timestamps();

            $table->foreign('id_anggota')->references('id')->on('anggota')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sertifikasi');
    }
};
