<?php

namespace App\Filament\Widgets;

use App\Models\Admin;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AdminCountWidget extends BaseWidget
{
    protected int | string | array $columnSpan = "3";

    protected function getColumns(): int
    {
        return 1; // Set the number of columns to 3
    }

    protected function getStats(): array
    {
        $totalAdmin = Admin::count();
        return [
            Stat::make('Jumlah Admin', $totalAdmin)
                ->description('Total admin yang terdaftar')
                ->icon('heroicon-o-users')
                ->color('primary')
                ->label('Admin'),
        ];
    }
}
