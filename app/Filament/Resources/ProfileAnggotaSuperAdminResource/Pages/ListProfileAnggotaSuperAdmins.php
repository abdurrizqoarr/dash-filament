<?php

namespace App\Filament\Resources\ProfileAnggotaSuperAdminResource\Pages;

use App\Filament\Resources\ProfileAnggotaSuperAdminResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProfileAnggotaSuperAdmins extends ListRecords
{
    protected static string $resource = ProfileAnggotaSuperAdminResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
