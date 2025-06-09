<?php

namespace App\Filament\Admin\Resources\RiwayatSertifikasiAnggotaAdminResource\Pages;

use App\Filament\Admin\Resources\RiwayatSertifikasiAnggotaAdminResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRiwayatSertifikasiAnggotaAdmins extends ListRecords
{
    protected static string $resource = RiwayatSertifikasiAnggotaAdminResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
