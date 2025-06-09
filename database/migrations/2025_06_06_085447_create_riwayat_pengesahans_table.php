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
        Schema::create('riwayat_pengesahan', function (Blueprint $table) {
            $table->uuid('id')->primary(); // Primary Key
            $table->uuid('id_anggota'); // Foreign Key
            $table->enum('tingkat', ['Tingkat I', 'Tingkat II', 'Tingkat III']);
            $table->text('cabang');
            $table->year('tahun');
            $table->string('sertifikat_pengesahan');
            $table->timestamps();

            $table->foreign('id_anggota')->references('id')->on('anggota')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_pengesahan');
    }
};
