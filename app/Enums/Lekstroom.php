<?php

namespace App\Enums;

use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasColor;


enum Lekstroom: string implements HasLabel, HasColor
// , HasIcon
{
    case Vervangende = 'Vervangende';
    case Reële = 'Reële';
 
    public function getLabel(): ?string
    {
        return match ($this) {
            self::Vervangende => 'Vervangende',
            self::Reële => 'Reële',
        };
    }
 
    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Vervangende => 'info',
            self::Reële => 'info',
        };
    }
 
    // public function getIcon(): ?string
    // {
    //     return match ($this) {
    //         self::Vervangende => 'heroicon-m-pencil',
    //         self::Reële => 'heroicon-m-eye',
    //     };
    // }
}