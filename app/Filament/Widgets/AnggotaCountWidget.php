<?php

namespace App\Filament\Widgets;

use App\Models\Anggota;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AnggotaCountWidget extends BaseWidget
{
    protected int | string | array $columnSpan = "3";

    protected function getColumns(): int
    {
        return 1; // Set the number of columns to 3
    }

    protected function getStats(): array
    {
        $totalAdmin = Anggota::count();

        return [
            Stat::make('Jumlah Anggota', $totalAdmin)
                ->description('Total anggota yang terdaftar')
                ->icon('heroicon-o-users')
                ->color('primary')
                ->label('Admin'),
        ];
    }
}
