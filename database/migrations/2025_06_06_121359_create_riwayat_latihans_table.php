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
        Schema::create('riwayat_latihan', function (Blueprint $table) {
            $table->uuid('id')->primary(); // Primary Key
            $table->uuid('id_anggota'); // Foreign Key
            $table->enum('tingkat', ['Tingkat Polos', 'Tingkat Jambon', 'Tingkat Hijau', 'Tingkat Putih']);
            $table->text('rayon');
            $table->text('sertifikat')->nullable(true);
            $table->string('penyelenggara');
            $table->timestamps();

            $table->foreign('id_anggota')->references('id')->on('anggota')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_latihan');
    }
};
