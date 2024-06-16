<?php

use App\Interfaces\BaseEnumInterface;

enum TriwulanEnum: string implements BaseEnumInterface
{
    case Q1 = 'Triwulan Pertama';
    case Q2 = 'Triwulan Kedua';
    case Q3 = 'Triwulan Ketiga';
    case Q4 = 'Triwulan Keempat';

    public function getStartMonth(): int
    {
        return match ($this) {
            self::Q1 => 1,
            self::Q2 => 4,
            self::Q3 => 7,
            self::Q4 => 10,
        };
    }

    public function getEndMonth(): int
    {
        return match ($this) {
            self::Q1 => 3,
            self::Q2 => 6,
            self::Q3 => 9,
            self::Q4 => 12,
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Q1 => 'bg-primary',
            self::Q2 => 'bg-info',
            self::Q3 => 'bg-warning',
            self::Q4 => 'bg-dark',
        };
    }

    public function label(): string
    {
        return match ($this) {
            self::Q1 => 'Januari s/d Maret',
            self::Q2 => 'April s/d Juni',
            self::Q3 => 'Juli s/d September',
            self::Q4 => 'Oktober s/d Desember',
        };
    }
}
