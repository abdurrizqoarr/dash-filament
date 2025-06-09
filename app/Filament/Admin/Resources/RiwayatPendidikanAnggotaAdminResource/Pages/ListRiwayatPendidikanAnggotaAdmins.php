<?php

namespace App\Filament\Admin\Resources\RiwayatPendidikanAnggotaAdminResource\Pages;

use App\Filament\Admin\Resources\RiwayatPendidikanAnggotaAdminResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRiwayatPendidikanAnggotaAdmins extends ListRecords
{
    protected static string $resource = RiwayatPendidikanAnggotaAdminResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
