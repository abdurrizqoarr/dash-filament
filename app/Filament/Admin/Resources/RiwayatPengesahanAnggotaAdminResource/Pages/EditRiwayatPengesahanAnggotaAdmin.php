<?php

namespace App\Filament\Admin\Resources\RiwayatPengesahanAnggotaAdminResource\Pages;

use App\Filament\Admin\Resources\RiwayatPengesahanAnggotaAdminResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRiwayatPengesahanAnggotaAdmin extends EditRecord
{
    protected static string $resource = RiwayatPengesahanAnggotaAdminResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
