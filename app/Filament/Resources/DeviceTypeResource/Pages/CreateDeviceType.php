<?php

namespace App\Filament\Resources\DeviceTypeResource\Pages;

use App\Filament\Resources\DeviceTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateDeviceType extends CreateRecord
{
    protected static bool $canCreateAnother = false;

    protected static string $resource = DeviceTypeResource::class;
}
