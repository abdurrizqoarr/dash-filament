<?php

namespace App\Filament\Anggota\Resources\RiwayatPelatihanResource\Pages;

use App\Filament\Anggota\Resources\RiwayatPelatihanResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateRiwayatPelatihan extends CreateRecord
{
    protected static string $resource = RiwayatPelatihanResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['id_anggota'] = Auth::guard('anggota')->id();
        return $data;
    }
}
