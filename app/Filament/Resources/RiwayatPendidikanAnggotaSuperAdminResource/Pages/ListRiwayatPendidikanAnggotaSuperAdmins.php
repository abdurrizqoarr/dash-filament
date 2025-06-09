<?php

namespace App\Filament\Resources\RiwayatPendidikanAnggotaSuperAdminResource\Pages;

use App\Filament\Resources\RiwayatPendidikanAnggotaSuperAdminResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRiwayatPendidikanAnggotaSuperAdmins extends ListRecords
{
    protected static string $resource = RiwayatPendidikanAnggotaSuperAdminResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
