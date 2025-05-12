<?php

namespace App\Filament\Resources\DutResource\Pages;

use App\Filament\Resources\DutResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateDut extends CreateRecord
{

	protected static bool $canCreateAnother = false;

    protected static string $resource = DutResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
{
    $data['user_id'] = auth()->id();

    return $data;
}
}
