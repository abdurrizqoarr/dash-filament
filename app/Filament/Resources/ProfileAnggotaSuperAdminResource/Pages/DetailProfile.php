<?php

namespace App\Filament\Resources\ProfileAnggotaSuperAdminResource\Pages;

use App\Filament\Resources\ProfileAnggotaSuperAdminResource;
use App\Models\Profile;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class DetailProfile extends ViewRecord
{
    protected static string $resource = ProfileAnggotaSuperAdminResource::class;

    public function getTitle(): string
    {
        return 'Detail Profile Anggota';
    }


    public function mount(int|string $record): void
    {
        // Ambil record Profile beserta relasi anggota dan ranting-nya
        $this->record = \App\Models\Profile::with(['anggota.ranting'])->findOrFail($record);

        $this->authorizeAccess();

        // Biarkan method fillForm() yang akan isi form
        $this->fillForm();
    }

    protected function fillForm(): void
    {
        $record = $this->getRecord();

        $this->form->fill([
            // Kolom langsung dari Profile
            'nomer_induk_warga' => $record->nomer_induk_warga,
            'nomer_induk_kependudukan' => $record->nomer_induk_kependudukan,
            'kartu_warga' => $record->kartu_warga,
            'ktp' => $record->ktp,
            'tempat_lahir' => $record->tempat_lahir,
            'tanggal_lahir' => $record->tanggal_lahir,
            'jenis_kelamin' => $record->jenis_kelamin,
            'status_pernikahan' => $record->status_pernikahan,
            'alamat' => $record->alamat,
            'jenis_pekerjaan' => $record->jenis_pekerjaan,
            'lembaga_instansi_bekerja' => $record->lembaga_instansi_bekerja,
            'alamat_lembaga_instansi_bekerja' => $record->alamat_lembaga_instansi_bekerja,

            // Dari relasi anggota
            'nama_anggota' => $record->anggota?->name,
            'username_anggota' => $record->anggota?->username,

            // Dari relasi ranting (via anggota)
            'nama_ranting' => $record->anggota?->ranting?->nama_ranting ?? '-',
        ]);
    }
}
