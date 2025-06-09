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
        Schema::create('profile', function (Blueprint $table) {
            $table->uuid('id')->primary(); // Primary Key
            $table->uuid('id_anggota')->unique(true); // Foreign Key
            $table->string('nomer_induk_warga')->unique();
            $table->string('nomer_induk_kependudukan')->nullable(); // Nullable
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['Pria', 'Perempuan']); // Boolean untuk Pria/perempuan
            $table->enum('status_pernikahan', ['Belum Kawin', 'Kawin', 'Duda', 'Janda']);
            $table->text('alamat');
            $table->enum('jenis_pekerjaan', [
                'Pedagang',
                'Wiraswasta',
                'Swasta',
                'Karyawan Perusahaan',
                'ASN',
                'TNI',
                'POLRI',
                'Lainnya'
            ])->nullable();
            $table->string('lembaga_instansi_bekerja')->nullable(); // Nullable
            $table->text('alamat_lembaga_instansi_bekerja')->nullable(); // Nullable
            $table->timestamps();

            // Relasi Foreign Key
            $table->foreign('id_anggota')->references('id')->on('anggota')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profile');
    }
};
