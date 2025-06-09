<?php

namespace App\Filament\Anggota\Resources\RiwayatPelatihanResource\Pages;

use App\Filament\Anggota\Resources\RiwayatPelatihanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRiwayatPelatihans extends ListRecords
{
    protected static string $resource = RiwayatPelatihanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
