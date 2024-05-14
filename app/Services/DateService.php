<?php

namespace App\Services;

use Carbon\Carbon;

/**
 * Class DateService
 * @package App\Services
 */
class DateService
{
    private Carbon $dateInstance;

    public function __construct()
    {
        $this->dateInstance = new Carbon;
    }

    /**
     * Get the current date.
     *
     * @return string
     */
    public function getCurrentDate()
    {
        return $this->dateInstance->now()->toDateString();
    }

    /**
     * Get the current date and time.
     *
     * @return string
     */
    public function getCurrentDateTime()
    {
        return $this->dateInstance->now()->toDateTimeString();
    }

    /**
     * Convert a date string to the preferred timezone.
     *
     * @param string $dateString
     * @param string $format
     * @param string $timezone
     * @return string
     */
    public function convertToPreferredTimezone($dateString, $format = 'Y-m-d H:i:s', $timezone = 'UTC')
    {
        return $this->dateInstance->parse($dateString)->timezone($timezone)->format($format);
    }
}
