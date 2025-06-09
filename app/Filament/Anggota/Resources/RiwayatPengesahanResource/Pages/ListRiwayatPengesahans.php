<?php

namespace App\Filament\Anggota\Resources\RiwayatPengesahanResource\Pages;

use App\Filament\Anggota\Resources\RiwayatPengesahanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRiwayatPengesahans extends ListRecords
{
    protected static string $resource = RiwayatPengesahanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
