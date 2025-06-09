<?php

namespace App\Filament\Anggota\Resources\RiwayatPendidikanResource\Pages;

use App\Filament\Anggota\Resources\RiwayatPendidikanResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateRiwayatPendidikan extends CreateRecord
{
    protected static string $resource = RiwayatPendidikanResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['id_anggota'] = Auth::guard('anggota')->id();
        return $data;
    }
}
