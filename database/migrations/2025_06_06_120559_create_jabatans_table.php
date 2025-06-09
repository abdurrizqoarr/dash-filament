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
        Schema::create('jabatan', function (Blueprint $table) {
            $table->uuid('id')->primary(); // Primary Key
            $table->uuid('id_anggota'); // Foreign Key
            $table->enum('lokasi_jabatan', ['Pusat', 'Provinsi', 'Cabang', 'Ranting', 'Rayon']);
            $table->string('jabatan');
            $table->string('sk_jabatan')->nullable(true);
            $table->timestamp('mulai_jabatan');
            $table->timestamp('akhir_jabatan')->nullable(true);
            $table->timestamps();

            $table->foreign('id_anggota')->references('id')->on('anggota')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jabatan');
    }
};
