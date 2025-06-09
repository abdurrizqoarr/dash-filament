<?php

namespace App\Filament\Anggota\Resources\RiwayatPengesahanResource\Pages;

use App\Filament\Anggota\Resources\RiwayatPengesahanResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRiwayatPengesahan extends EditRecord
{
    protected static string $resource = RiwayatPengesahanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
