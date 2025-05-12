<?php

namespace App\Filament\Resources\DutResource\Pages;

use App\Filament\Resources\DutResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Pages\Actions\CreateAction;

use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;

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
			'all' => Tab::make('Alle registraties'),
			'active' => Tab::make('In gebruik')
			->modifyQueryUsing(fn (Builder $query) => $query->where('status', true)),
			'inactive' => Tab::make('Buiten gebruik')
			->modifyQueryUsing(fn (Builder $query) => $query->where('status', false)),
		];
	}



}
