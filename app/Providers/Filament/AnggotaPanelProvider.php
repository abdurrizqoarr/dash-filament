<?php

namespace App\Providers\Filament;

use App\customFilament\LoginCustom;
use App\Filament\Anggota\Pages\AnggotaLogin;
use App\Filament\Anggota\Pages\Profile;
use App\Filament\Anggota\Pages\UserSetting;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AnggotaPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('anggota')
            ->path('anggota')
            ->login(AnggotaLogin::class)
            ->authGuard('anggota')
            ->colors([
                'primary' => Color::Amber,
            ])
            ->discoverResources(in: app_path('Filament/Anggota/Resources'), for: 'App\\Filament\\Anggota\\Resources')
            ->discoverPages(in: app_path('Filament/Anggota/Pages'), for: 'App\\Filament\\Anggota\\Pages')
            ->pages([
                Profile::class,
                UserSetting::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Anggota/Widgets'), for: 'App\\Filament\\Anggota\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
