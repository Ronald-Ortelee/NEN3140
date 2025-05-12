<?php

namespace App\Enums;

use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasColor;

enum InspectionResult: string implements HasLabel, HasColor
//, HasIcon

{
    case GOED = 'Goed';
    case FOUT = 'Afkeur';
    case REPARATIE = 'Reparatie';
    case ONBEKEND = 'Onbekend';
 
    public function getLabel(): ?string
    {
        return match ($this) {
            self::GOED => 'Goed',
            self::FOUT => 'Afkeur',
            self::REPARATIE => 'Reparatie',
            self::ONBEKEND => 'Onbekend',
        };
    }
 
    public function getColor(): string|array|null
    {
        return match ($this) {
            self::GOED => 'success',
            self::FOUT => 'danger',
            self::REPARATIE => 'warning',
            self::ONBEKEND => 'gray',
        };
    }
 
    public function getIcon(): ?string
    {
        return match ($this) {
            self::GOED => 'heroicon-m-check',
            self::FOUT => 'heroicon-m-x-circle',
            self::REPARATIE => 'heroicon-m-wrench',
            self::ONBEKEND => 'heroicon-m-wrench',
        };
    }

}
