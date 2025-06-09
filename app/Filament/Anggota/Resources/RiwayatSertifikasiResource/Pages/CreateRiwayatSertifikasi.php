<?php

namespace App\Filament\Anggota\Resources\RiwayatSertifikasiResource\Pages;

use App\Filament\Anggota\Resources\RiwayatSertifikasiResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateRiwayatSertifikasi extends CreateRecord
{
    protected static string $resource = RiwayatSertifikasiResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['id_anggota'] = Auth::guard('anggota')->id();
        return $data;
    }
}
