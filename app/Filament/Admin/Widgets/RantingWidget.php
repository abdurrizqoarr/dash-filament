<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Ranting;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class RantingWidget extends BaseWidget
{
    protected int | string | array $columnSpan = "4";

    protected function getColumns(): int
    {
        return 1; // Set the number of columns to 3
    }

    protected function getStats(): array
    {
        $idRanting = Auth::guard('admin')->user()->id_ranting;
        $ranting = Ranting::where('id', $idRanting)->first();

        return [
            Stat::make('Ranting', $ranting->nama_ranting)
                ->icon('heroicon-s-share')
                ->color('primary')
                ->label('Ranting'),
        ];
    }
}
