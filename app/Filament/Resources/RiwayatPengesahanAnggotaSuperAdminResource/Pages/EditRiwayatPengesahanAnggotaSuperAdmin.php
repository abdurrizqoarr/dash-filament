<?php

namespace App\Filament\Resources\RiwayatPengesahanAnggotaSuperAdminResource\Pages;

use App\Filament\Resources\RiwayatPengesahanAnggotaSuperAdminResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRiwayatPengesahanAnggotaSuperAdmin extends EditRecord
{
    protected static string $resource = RiwayatPengesahanAnggotaSuperAdminResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
