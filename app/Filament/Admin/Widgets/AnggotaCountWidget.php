<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Anggota;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class AnggotaCountWidget extends BaseWidget
{
    protected int | string | array $columnSpan = "4";

    protected function getColumns(): int
    {
        return 1; // Set the number of columns to 3
    }

    protected function getStats(): array
    {
        $idRanting = Auth::guard('admin')->user()->id_ranting;
        $totalAdmin = Anggota::where('id_ranting', $idRanting)->count();

        return [
            Stat::make('Jumlah Anggota', $totalAdmin)
                ->description('Total anggota yang terdaftar')
                ->icon('heroicon-o-users')
                ->color('primary')
                ->label('Anggota'),
        ];
    }
}
