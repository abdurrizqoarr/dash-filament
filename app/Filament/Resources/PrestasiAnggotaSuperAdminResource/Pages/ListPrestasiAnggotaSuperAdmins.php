<?php

namespace App\Filament\Resources\PrestasiAnggotaSuperAdminResource\Pages;

use App\Filament\Resources\PrestasiAnggotaSuperAdminResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPrestasiAnggotaSuperAdmins extends ListRecords
{
    protected static string $resource = PrestasiAnggotaSuperAdminResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
