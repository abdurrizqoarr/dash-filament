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
        Schema::create('riwayat_pendidikan', function (Blueprint $table) {
            $table->uuid('id')->primary(); // Primary Key
            $table->uuid('id_anggota');
            $table->enum('tingakt_pendidikan', [
                'SD / Sederajat',
                'SMP / Sederajat',
                'SMA / Sederajat',
                'SMK',
                'DI',
                'D-II',
                'D-III',
                'D-IV / Sarjana',
                'Pasca Sarjana - S2',
                'Pasca Sarjana - S3'
            ]);
            $table->string('nama_instansi');
            $table->string('ijazah');
            $table->year('tahun_lulus')->nullable();
            $table->timestamps();

            $table->foreign('id_anggota')->references('id')->on('anggota')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_pendidikan');
    }
};
