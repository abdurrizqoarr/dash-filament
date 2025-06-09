<?php

namespace App\Filament\Admin\Resources\JabatanAdminResource\Pages;

use App\Filament\Admin\Resources\JabatanAdminResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListJabatanAdmins extends ListRecords
{
    protected static string $resource = JabatanAdminResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
