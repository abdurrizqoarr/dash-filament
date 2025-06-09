<?php

namespace App\Filament\Anggota\Resources\RiwayatPendidikanResource\Pages;

use App\Filament\Anggota\Resources\RiwayatPendidikanResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRiwayatPendidikan extends EditRecord
{
    protected static string $resource = RiwayatPendidikanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
