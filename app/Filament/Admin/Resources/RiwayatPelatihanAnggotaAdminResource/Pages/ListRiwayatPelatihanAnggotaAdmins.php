<?php

namespace App\Filament\Admin\Resources\RiwayatPelatihanAnggotaAdminResource\Pages;

use App\Filament\Admin\Resources\RiwayatPelatihanAnggotaAdminResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRiwayatPelatihanAnggotaAdmins extends ListRecords
{
    protected static string $resource = RiwayatPelatihanAnggotaAdminResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
