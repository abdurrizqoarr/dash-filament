<?php

namespace App\Filament\Resources\RiwayatPelatihanAnggotaSuperAdminResource\Pages;

use App\Filament\Resources\RiwayatPelatihanAnggotaSuperAdminResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRiwayatPelatihanAnggotaSuperAdmin extends EditRecord
{
    protected static string $resource = RiwayatPelatihanAnggotaSuperAdminResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
