<?php

namespace App\Helpers;

class ColorHelper
{
    /**
     * Convert color between HEX and RGB formats.
     *
     * @param string $color The color value in either HEX or RGB format.
     *
     * @return array|string|false Returns an array containing RGB values if input is HEX,
     *                            a string containing HEX color if input is RGB,
     *                            or false if input is invalid.
     */
    public static function convertColor($color)
    {
        // Check if input is HEX or RGB
        if (strpos($color, '#') !== false) {
            // HEX to RGB
            list($r, $g, $b) = sscanf($color, "#%02x%02x%02x");
            return [$r, $g, $b];
        } elseif (preg_match('/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/', $color, $matches)) {
            // RGB to HEX
            $hex = '#';
            $hex .= str_pad(dechex($matches[1]), 2, '0', STR_PAD_LEFT);
            $hex .= str_pad(dechex($matches[2]), 2, '0', STR_PAD_LEFT);
            $hex .= str_pad(dechex($matches[3]), 2, '0', STR_PAD_LEFT);
            return $hex;
        } else {
            return false; // Invalid input
        }
    }

    /**
     * Generate HEX or RGBA color string.
     *
     * @param array $color The color values in RGB format [R, G, B].
     * @param float $alpha The alpha (opacity) value (0.0 - 1.0).
     * @param bool $rgba If true, generates RGBA color string; otherwise, generates HEX color string.
     *
     * @return string Returns a string containing either HEX or RGBA color representation.
     */
    public static function generateColor($color, $alpha = 1.0, $rgba = false)
    {
        if ($rgba) {
            // Generate RGBA color string
            $rgbaColor = 'rgba(' . implode(', ', $color) . ', ' . $alpha . ')';
            return $rgbaColor;
        } else {
            // Generate HEX color string
            $hexColor = '#';
            $hexColor .= str_pad(dechex($color[0]), 2, '0', STR_PAD_LEFT);
            $hexColor .= str_pad(dechex($color[1]), 2, '0', STR_PAD_LEFT);
            $hexColor .= str_pad(dechex($color[2]), 2, '0', STR_PAD_LEFT);
            return $hexColor;
        }
    }

    /**
     * Generate a random HEX or RGBA color string.
     *
     * @param bool $rgba If true, generates a random RGBA color string; otherwise, generates a random HEX color string.
     * @param float $alpha The alpha (opacity) value (0.0 - 1.0) for RGBA colors.
     *
     * @return string Returns a random color string.
     */
    public static function generateRandomColor($rgba = false, $alpha = 1.0)
    {
        // Generate random RGB values
        $r = mt_rand(0, 255);
        $g = mt_rand(0, 255);
        $b = mt_rand(0, 255);

        if ($rgba) {
            // Generate random RGBA color string
            $rgbaColor = 'rgba(' . $r . ', ' . $g . ', ' . $b . ', ' . $alpha . ')';
            return $rgbaColor;
        } else {
            // Generate random HEX color string
            $hexColor = '#';
            $hexColor .= str_pad(dechex($r), 2, '0', STR_PAD_LEFT);
            $hexColor .= str_pad(dechex($g), 2, '0', STR_PAD_LEFT);
            $hexColor .= str_pad(dechex($b), 2, '0', STR_PAD_LEFT);
            return $hexColor;
        }
    }
}
