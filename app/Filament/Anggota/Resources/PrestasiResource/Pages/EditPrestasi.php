<?php

namespace App\Filament\Anggota\Resources\PrestasiResource\Pages;

use App\Filament\Anggota\Resources\PrestasiResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPrestasi extends EditRecord
{
    protected static string $resource = PrestasiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
