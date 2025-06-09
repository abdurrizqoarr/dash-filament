<?php

namespace App\Filament\Resources\RantingResource\Pages;

use App\Filament\Resources\RantingResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRanting extends EditRecord
{
    protected static string $resource = RantingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
