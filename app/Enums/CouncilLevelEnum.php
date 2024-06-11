<?php

namespace App\Enums;
use App\Interfaces\BaseEnumInterface;

enum CouncilLevelEnum: string implements BaseEnumInterface
{
    case GUDEP = 'gudep';
    case DISTRICT = 'ranting';
    case REGENCY = 'cabang';
    case REGION = 'daerah';
    case NATIONAL = 'nasional';
    case INTERNATIONAL = 'internasional';

    /**
     * Give the label for the case
     *
     * @return string
     */
    public function label(): string
    {
        return match($this) {
            self::GUDEP => 'Gugus Depan',
            self::DISTRICT => 'Ranting',
            self::REGENCY => 'Cabang',
            self::REGION => 'Daerah',
            self::NATIONAL => 'Nasional',
            self::INTERNATIONAL => 'Internasional',
        };
    }

    /**
     * Give the color class for the case
     *
     * @return string
     */
    public function color(): string
    {
        return match($this) {
            self::GUDEP => 'danger',
            self::DISTRICT => 'warning',
            self::REGENCY => 'primary',
            self::REGION => 'secondary',
            self::NATIONAL => 'success',
            self::INTERNATIONAL => 'info',
        };
    }
}
