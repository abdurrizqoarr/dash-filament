<?php

namespace App\Filament\Admin\Resources\PrestasiAnggotaAdminResource\Pages;

use App\Filament\Admin\Resources\PrestasiAnggotaAdminResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPrestasiAnggotaAdmins extends ListRecords
{
    protected static string $resource = PrestasiAnggotaAdminResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
