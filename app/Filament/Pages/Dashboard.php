<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\AdminCountWidget;
use App\Filament\Widgets\AnggotaCountWidget;
use App\Filament\Widgets\ProfileCountWidget;
use App\Filament\Widgets\RantingCountWidget;
use App\Filament\Widgets\ResetAkunWidget;
use Filament\Pages\Page;

class Dashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-home';

    protected static ?string $navigationGroup = 'DASHBOARD';
    protected static string $view = 'filament.pages.dashboard';

    public function getHeaderWidgetsColumns(): int
    {
        return 12;
    }

    protected function getHeaderWidgets(): array
    {
        return [
            RantingCountWidget::class,
            AdminCountWidget::class,
            AnggotaCountWidget::class,
            ProfileCountWidget::class,
        ];
    }

    protected function getFooterWidgets(): array
    {
        return [
            ResetAkunWidget::class,
        ];
    }
}
