<?php

namespace App\Helpers;

/**
 * Helper class for URL-related operations.
 */
class URLHelper
{
    /**
     * Convert an array to an encoded URL string.
     *
     * @param array $array The input array to be encoded.
     * @return string The encoded URL string.
     * @example URLHelper::encodeArrayToURL(['foo' => 'bar', 'baz' => 'qux']) => "foo=bar&baz=qux"
     */
    public static function encodeArrayToURL($array)
    {
        $encodedPairs = collect($array)->map(function ($value, $key) {
            return urlencode($key). '='. urlencode($value);
        })->implode('&');

        return $encodedPairs;
    }

    /**
     * Check if the current URL matches the exact route.
     *
     * @param string $currentRoute The route to check against.
     * @return bool True if the current URL matches the exact route, false otherwise.
     * @example URLHelper::isExactUrl('home') => true if the current URL is exactly the "home" route
     */
    public static function isExactUrl($currentRoute)
    {
        $currentUrl = request()->fullUrl();
        return strpos($currentUrl, route($currentRoute)) === 0;
    }
}
