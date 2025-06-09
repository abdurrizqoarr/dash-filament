<?php

namespace App\Filament\Resources\RiwayatPelatihanAnggotaSuperAdminResource\Pages;

use App\Filament\Resources\RiwayatPelatihanAnggotaSuperAdminResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRiwayatPelatihanAnggotaSuperAdmins extends ListRecords
{
    protected static string $resource = RiwayatPelatihanAnggotaSuperAdminResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
