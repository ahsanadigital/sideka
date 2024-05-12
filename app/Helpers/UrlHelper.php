<?php

namespace App\Helpers;

/**
 * Helper class for encoding arrays to URL strings.
 */
class URLHelper
{
    /**
     * Convert an array to an encoded URL string.
     *
     * @param array $array The input array.
     * @return string The encoded URL string.
     */
    public static function encodeArrayToURL($array)
    {
        $encodedPairs = collect($array)->map(function ($value, $key) {
            return urlencode($key) . '=' . urlencode($value);
        })->implode('&');

        return $encodedPairs;
    }
}
