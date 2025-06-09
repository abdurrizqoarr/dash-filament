<?php

namespace App\Filament\Anggota\Resources\JabatanResource\Pages;

use App\Filament\Anggota\Resources\JabatanResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateJabatan extends CreateRecord
{
    protected static string $resource = JabatanResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['id_anggota'] = Auth::guard('anggota')->id();
        return $data;
    }
}
