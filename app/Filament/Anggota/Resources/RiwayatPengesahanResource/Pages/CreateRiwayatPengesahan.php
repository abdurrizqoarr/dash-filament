<?php

namespace App\Filament\Anggota\Resources\RiwayatPengesahanResource\Pages;

use App\Filament\Anggota\Resources\RiwayatPengesahanResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateRiwayatPengesahan extends CreateRecord
{
    protected static string $resource = RiwayatPengesahanResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['id_anggota'] = Auth::guard('anggota')->id();
        return $data;
    }
}
