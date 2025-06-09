<?php

namespace App\Filament\Resources\JabatanSuperAdminResource\Pages;

use App\Filament\Resources\JabatanSuperAdminResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditJabatanSuperAdmin extends EditRecord
{
    protected static string $resource = JabatanSuperAdminResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
