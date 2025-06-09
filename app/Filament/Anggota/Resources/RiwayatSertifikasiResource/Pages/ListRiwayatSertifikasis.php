<?php

namespace App\Filament\Anggota\Resources\RiwayatSertifikasiResource\Pages;

use App\Filament\Anggota\Resources\RiwayatSertifikasiResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRiwayatSertifikasis extends ListRecords
{
    protected static string $resource = RiwayatSertifikasiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
