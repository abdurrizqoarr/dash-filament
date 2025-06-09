<?php

namespace App\Filament\Widgets;

use App\Models\Profile;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ProfileCountWidget extends BaseWidget
{
    protected int | string | array $columnSpan = "3";

    protected function getColumns(): int
    {
        return 1; // Set the number of columns to 3
    }
    
    protected function getStats(): array
    {
        $totalAdmin = Profile::count();
        return [
            Stat::make('Jumlah Profile', $totalAdmin)
                ->description('Total user yang telah membuat profile')
                ->icon('heroicon-c-user-circle')
                ->color('primary')
                ->label('Profile'),
        ];
    }
}
