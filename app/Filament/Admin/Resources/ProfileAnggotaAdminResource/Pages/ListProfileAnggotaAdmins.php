<?php

namespace App\Filament\Admin\Resources\ProfileAnggotaAdminResource\Pages;

use App\Filament\Admin\Resources\ProfileAnggotaAdminResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProfileAnggotaAdmins extends ListRecords
{
    protected static string $resource = ProfileAnggotaAdminResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
