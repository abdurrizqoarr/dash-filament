<?php

namespace App\Filament\Admin\Pages;

use App\Filament\Admin\Widgets\AnggotaCountWidget;
use App\Filament\Admin\Widgets\ProfileCountWidget;
use App\Filament\Admin\Widgets\RantingWidget;
use Filament\Pages\Page;

class Dashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-home';

    protected static string $view = 'filament.admin.pages.dashboard';
    protected static ?string $navigationGroup = 'DASHBOARD';

    public function getHeaderWidgetsColumns(): int
    {
        return 12;
    }

    protected function getHeaderWidgets(): array
    {
        return [
            RantingWidget::class,
            AnggotaCountWidget::class,
            ProfileCountWidget::class,
        ];
    }

    protected function getFooterWidgets(): array
    {
        return [
            \App\Filament\Admin\Widgets\ResetAkunWidget::class,
        ];
    }
}
