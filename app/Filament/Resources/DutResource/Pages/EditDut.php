<?php

namespace App\Filament\Resources\DutResource\Pages;

use App\Filament\Resources\DutResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;


class EditDut extends EditRecord
{

	protected static string $resource = DutResource::class;


	protected function getHeaderActions(): array
	{
		return [
			Actions\DeleteAction::make(),
		];
	}


	//Redirect to list after save
	protected function getRedirectUrl(): ?string
	{
		return static::getResource()::getUrl('index');
	}


	protected $listeners = [
		'refreshPlaceholders' => 'handleRefreshPlaceholders',
	];

	public function handleRefreshPlaceholders(): void
	{
        // Refresh only the placeholders
		$this->refreshFormData(['Laatste_inspectie', 'Volgende_inspectie']);

        // Alternatively, refresh the entire form:
        // $this->emitSelf('$refresh');
	}

}
