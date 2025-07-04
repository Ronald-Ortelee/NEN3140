<?php

namespace App\Providers\Filament;

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

use ShuvroRoy\FilamentSpatieLaravelBackup\FilamentSpatieLaravelBackupPlugin;
use Filament\View\PanelsRenderHook;
use Filament\Support\Facades\FilamentView;

class AdminPanelProvider extends PanelProvider
{
	public function panel(Panel $panel): Panel
	{
		return $panel
		->brandLogo(asset('images/CREA_logo_light.svg'))
		->brandLogoHeight('3rem')

		->default()
		->id('admin')
		->path('admin')
		->login()
            ->breadcrumbs(false) // Disable breadcrumbs globally
            ->colors([
            	'primary' => Color::Amber,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
            	Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
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
            ])

            ->plugin(FilamentSpatieLaravelBackupPlugin::make()
            	->noTimeout()
            );
            
        }

        public function boot(): void
        {
        	FilamentView::registerRenderHook(
        		PanelsRenderHook::GLOBAL_SEARCH_AFTER,
        		fn (): string => '
        		<div x-data="{ mode: document.documentElement.classList.contains(\'dark\') ? \'dark\' : \'light\' }"
        		x-on:dark-mode-toggled.window="mode = $event.detail">
        		<a href="https://github.com/Ronald-Ortelee/NEN3140" target="_blank" rel="noopener noreferrer">
        		<img x-show="mode === \'light\'" src="' . asset('images/github-mark-dark.svg') . '" alt="GitHub Light" class="h-8 w-8 mr-2">
        		<img x-show="mode === \'dark\'" src="' . asset('images/github-mark-white.svg') . '" alt="GitHub Dark" class="h-8 w-8 mr-2">
        		</a>
        		</div>'
        	);
        }

    }
