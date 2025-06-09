<?php

namespace App\Filament\Resources\RiwayatPendidikanAnggotaSuperAdminResource\Pages;

use App\Filament\Resources\RiwayatPendidikanAnggotaSuperAdminResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRiwayatPendidikanAnggotaSuperAdmin extends EditRecord
{
    protected static string $resource = RiwayatPendidikanAnggotaSuperAdminResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
