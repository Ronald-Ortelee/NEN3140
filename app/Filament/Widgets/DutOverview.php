<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

use App\Models\Dut;

class DutOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
           // Stat::make('Geregistreerde arbeidsmiddelen', Dut::count())
           
            // ->chart(
            //     Dut::selectRaw('DAY(created_at) as day, COUNT(*) as count')
            //         ->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])
            //         ->groupBy('day')
            //         ->pluck('count')
            //         ->toArray()
            // ),


            Stat::make('Geregistreerde arbeidsmiddelen', Dut::count())
                ->description('32k increase')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('success'),
            Stat::make('New customers', '$')
                ->description('3% decrease')
                ->descriptionIcon('heroicon-m-arrow-trending-down')
                ->chart([17, 16, 14, 15, 14, 13, 12])
                ->color('danger'),
            Stat::make('New orders', '$')
                ->description('7% increase')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart([15, 4, 10, 2, 12, 4, 12])
                ->color('success'),









        ];
    }
}
