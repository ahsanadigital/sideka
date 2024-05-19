<?php

namespace App\Enums;
use App\Interfaces\BaseEnumInterface;

enum CouncilCategoryEnum: string implements BaseEnumInterface {
    case ACTIVITY = "activity";
    case COUNCILS = "councils";
    case SPECIALUNIT = "special_unit";
    case OTHER = "other";

    /**
     * Give the label for the case
     *
     * @return string
     */
    public function label(): string
    {
        return match ($this) {
            self::ACTIVITY => "Aktivitas",
            self::COUNCILS => "Dewan Kerja",
            self::SPECIALUNIT => "Satuan Karya",
            self::OTHER => "Lain-Lain",
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
            self::ACTIVITY => "bg-primary",
            self::COUNCILS => "bg-secondary",
            self::SPECIALUNIT => "bg-success",
            self::OTHER => "bg-danger",
        };
    }
}
