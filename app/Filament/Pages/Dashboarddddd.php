<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class Dashboardt extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.dashboardt';

    protected function getWidgets(): array
    {
        return [
            SalesStats::class,
            OrdersChart::class,
        ];
    }
    
}
