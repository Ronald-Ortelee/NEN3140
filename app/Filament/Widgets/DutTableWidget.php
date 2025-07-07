<?php

namespace App\Filament\Widgets;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Inspection;
use App\Models\Dut;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DutTableWidget extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';

    public function getTableHeading(): string
    {
        return 'Eerstvolgende inspecties';
    }

    protected function getTableQuery(): Builder
    {
        return Dut::query()
            ->where('status', '!=', 0)
            ->leftJoin('device_types', 'duts.devicetype_id', '=', 'device_types.id')
            ->leftJoin('categories', 'device_types.category_id', '=', 'categories.id')
            ->leftJoin('brands', 'duts.brand_id', '=', 'brands.id')
            ->addSelect([
                'duts.*',
                'device_types.name as device_type_name',
                'brands.name as brand_name',
                'latest_inspection_date' => Inspection::select('date_of_inspection')
                    ->whereColumn('dut_id', 'duts.id')
                    ->latest('date_of_inspection')
                    ->limit(1),
                'inspection_interval' => DB::raw('COALESCE(categories.inspection_interval, 1)'),
            ])
            ->orderByRaw('DATE_ADD(latest_inspection_date, INTERVAL inspection_interval YEAR) ASC');
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('id')
                ->numeric(decimalPlaces: 0)
                ->numeric(thousandsSeparator: '')
                ->badge()
                ->label('CREA ID'),
            TextColumn::make('device_type_name')
                ->label('Type')
                ->sortable(),
            TextColumn::make('brand_name')
                ->label('Merk')
                ->sortable(),
            TextColumn::make('DutLocationId.name')
                ->numeric()
                ->label('Locatie'),
            TextColumn::make('next_inspection_date')
                ->label('Volgende inspectie')
                ->getStateUsing(function ($record) {
                    $latestInspection = $record->inspections()->latest('date_of_inspection')->first();
                    $interval = $record->DutsInCategory->inspection_interval ?? 1;
                    if ($latestInspection) {
                        return Carbon::parse($latestInspection->date_of_inspection)->addYears($interval)->format('Y-m-d');
                    }
                    return null; // Or 'Nog nooit gekeurd'
                })
                ->formatStateUsing(function ($state) {
                    return $state ? Carbon::parse($state)->format('d-m-Y') : 'Nog nooit gekeurd';
                }),
        ];
    }

    protected function getTableRecordsPerPageSelectOptions(): array
    {
        return [5];
    }

    protected function getTableRecordUrlUsing(): ?\Closure
    {
        return fn ($record) => route('filament.admin.resources.duts.edit', ['record' => $record->id]);
    }
}