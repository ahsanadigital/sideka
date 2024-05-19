<?php

namespace App\Enums;

use App\Interfaces\BaseEnumInterface;

enum MeetingTypeEnum: string implements BaseEnumInterface
{
    case PLENO = 'pleno';
    case COUNCIL = 'kwartir';
    case DIVISION = 'bidang';
    case EVENT = 'kegiatan';
    case OTHER = 'lain';

    /**
     * Give the label for the case
     *
     * @return string
     */
    public function label(): string
    {
        return match ($this) {
            self::PLENO => 'Rapat Pleno',
            self::COUNCIL => 'Rapat Kwartir',
            self::DIVISION => 'Rapat Bidang',
            self::EVENT => 'Rapat Kegiatan',
            self::OTHER => 'Rapat Lain-lain',
        };
    }

    /**
     * Give the color class for the case
     *
     * @return string
     */
    public function color(): string
    {
        return match ($this) {
            self::PLENO => 'bg-danger',
            self::COUNCIL => 'bg-success',
            self::DIVISION => 'bg-primary',
            self::EVENT => 'bg-info',
            self::OTHER => 'bg-secondary',
        };
    }
}
