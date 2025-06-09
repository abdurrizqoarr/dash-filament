<?php

namespace App\Filament\Resources\RiwayatSertifikasiAnggotaSuperAdminResource\Pages;

use App\Filament\Resources\RiwayatSertifikasiAnggotaSuperAdminResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRiwayatSertifikasiAnggotaSuperAdmin extends EditRecord
{
    protected static string $resource = RiwayatSertifikasiAnggotaSuperAdminResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
