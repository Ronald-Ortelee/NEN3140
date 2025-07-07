<?php

namespace App\Filament\Resources\DutResource\Pages;

use App\Filament\Resources\DutResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Pages\Actions\CreateAction;

use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Dut;
class ListDuts extends ListRecords
{
	protected static string $resource = DutResource::class;

	// protected static ?string $modelLabel = ' University';

	// protected static ?string $pluralModelLabel = 'Universities';

	protected function getHeaderActions(): array
	{
		return [
			CreateAction::make()->label('Nieuwe registratie')
		];
	} 


	public function getTabs(): array
{
    return [
        'all' => Tab::make('Alle registraties')
            ->badge(fn () => Dut::query()->count()),

        'active' => Tab::make('In gebruik')
            ->badge(fn () => Dut::where('status', true)->count())
            ->modifyQueryUsing(fn (Builder $query) => $query->where('status', true)),

        'inactive' => Tab::make('Buiten gebruik')
            ->badge(fn () => Dut::where('status', false)->count())
            ->modifyQueryUsing(fn (Builder $query) => $query->where('status', false)),
    ];
}



}
