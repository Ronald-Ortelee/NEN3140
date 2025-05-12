<?php

namespace App\Enums;

use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasColor;

enum PassFail: string implements HasLabel, HasColor, HasIcon
{
    case GOED = 'Goed';
    case FOUT = 'fout';
 
    public function getLabel(): ?string
    {
        return match ($this) {
            self::GOED => 'Goed',
            self::FOUT => 'Fout',
        };
    }
 
    public function getColor(): string|array|null
    {
        return match ($this) {
            self::GOED => 'success',
            self::FOUT => 'danger',
        };
    }
 
    public function getIcon(): ?string
    {
        return match ($this) {
            self::GOED => 'heroicon-m-check-badge',
            self::FOUT => 'heroicon-m-x-circle',
        };
    }
}