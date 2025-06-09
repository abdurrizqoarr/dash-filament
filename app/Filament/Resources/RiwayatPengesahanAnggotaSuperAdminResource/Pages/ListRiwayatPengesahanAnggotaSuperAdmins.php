<?php

namespace App\Filament\Resources\RiwayatPengesahanAnggotaSuperAdminResource\Pages;

use App\Filament\Resources\RiwayatPengesahanAnggotaSuperAdminResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRiwayatPengesahanAnggotaSuperAdmins extends ListRecords
{
    protected static string $resource = RiwayatPengesahanAnggotaSuperAdminResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
