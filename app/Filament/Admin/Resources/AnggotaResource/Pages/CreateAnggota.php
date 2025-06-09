<?php

namespace App\Filament\Admin\Resources\AnggotaResource\Pages;

use App\Filament\Admin\Resources\AnggotaResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateAnggota extends CreateRecord
{
    protected static string $resource = AnggotaResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Ambil id_instansi dari user login dan tambahkan ke data
        $data['id_ranting'] = Auth::guard('admin')->user()->id_ranting;
        return $data;
    }
}
