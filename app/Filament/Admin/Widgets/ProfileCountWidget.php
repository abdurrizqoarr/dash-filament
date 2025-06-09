<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Profile;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class ProfileCountWidget extends BaseWidget
{
    protected int | string | array $columnSpan = "4";

    protected function getColumns(): int
    {
        return 1; // Set the number of columns to 3
    }

    protected function getStats(): array
    {
        $idRanting = Auth::guard('admin')->user()->id_ranting;
        $totalAdmin = Profile::whereHas('anggota', function ($query) use ($idRanting) {
            $query->where('id_ranting', $idRanting);
        })->count();

        return [
            Stat::make('Jumlah Profile', $totalAdmin)
                ->description('Total anggota yang telah membuat profile')
                ->icon('heroicon-c-user-circle')
                ->color('primary')
                ->label('Profile'),
        ];
    }
}
