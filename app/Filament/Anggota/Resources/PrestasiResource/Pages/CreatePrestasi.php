<?php

namespace App\Filament\Anggota\Resources\PrestasiResource\Pages;

use App\Filament\Anggota\Resources\PrestasiResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreatePrestasi extends CreateRecord
{
    protected static string $resource = PrestasiResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['id_anggota'] = Auth::guard('anggota')->id();
        return $data;
    }
}
