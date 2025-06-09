<?php

namespace App\Filament\Widgets;

use App\Models\Ranting;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class RantingCountWidget extends BaseWidget
{
    protected int | string | array $columnSpan = "3";

    protected function getColumns(): int
    {
        return 1; // Set the number of columns to 3
    }

    protected function getStats(): array
    {
        $totalAdmin = Ranting::count();
        return [
            Stat::make('Jumlah Ranting', $totalAdmin)
                ->description('Total Ranting yang terdaftar')
                ->icon('heroicon-s-share')
                ->color('primary')
                ->label('Ranting'),
        ];
    }
}
