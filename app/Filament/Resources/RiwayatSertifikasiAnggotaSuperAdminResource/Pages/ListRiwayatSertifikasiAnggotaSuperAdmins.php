<?php

namespace App\Filament\Resources\RiwayatSertifikasiAnggotaSuperAdminResource\Pages;

use App\Filament\Resources\RiwayatSertifikasiAnggotaSuperAdminResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRiwayatSertifikasiAnggotaSuperAdmins extends ListRecords
{
    protected static string $resource = RiwayatSertifikasiAnggotaSuperAdminResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
