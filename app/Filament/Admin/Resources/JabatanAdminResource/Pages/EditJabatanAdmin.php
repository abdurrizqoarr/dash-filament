<?php

namespace App\Filament\Admin\Resources\JabatanAdminResource\Pages;

use App\Filament\Admin\Resources\JabatanAdminResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditJabatanAdmin extends EditRecord
{
    protected static string $resource = JabatanAdminResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
