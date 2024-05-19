<?php

namespace App\Enums;

use App\Interfaces\BaseEnumInterface;

enum RoleUserEnum: string implements BaseEnumInterface
{
    case DKD = 'region';
    case DKC = 'regency';
    case DKR = 'district';

    /**
     * Give the label for case
     *
     * @return string
     */
    public function label(): string
    {
        return match ($this) {
            self::DKD => 'Dewan Kerja Daerah',
            self::DKC => 'Dewan Kerja Cabang',
            self::DKR => 'Dewan Kerja Ranting',
            default => 'Dewan Kerja Daerah',
        };
    }

    /**
     * Give the color class for case
     *
     * @return string
     */
    public function color(): string
    {
        return match ($this) {
            self::DKD => 'bg-danger',
            self::DKC => 'bg-success',
            self::DKR => 'bg-primary',
            default => 'bg-dark',
        };
    }
}
