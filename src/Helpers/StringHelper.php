<?php

/**
 * String helper.
 *
 * @package     MikeWelsh\LittleDevils\Helpers\StringHelper
 * @author      Mike Welsh (mike@amigamike.com)
 * @copyright   2020 Mike Welsh
 */

namespace MikeWelsh\LittleDevils\Helpers;

class StringHelper
{
    /**
     * Generate a random string.
     */
    public static function random(
        int $length = 64,
        string $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ$!&*()-'
    ): string {
        /*
         * If the length is less than one, throw an error.
         */
        if ($length < 1) {
            throw new \RangeException("Length must be a positive integer");
        }

        /*
         * Define the pieces array.
         */
        $pieces = [];

        /*
         * Generate a max length passed on the keyspace.
         */
        $max = mb_strlen($keyspace, '8bit') - 1;

        /*
         * Loop through and build pieces.
         */
        for ($i = 0; $i < $length; ++$i) {
            $pieces[] = $keyspace[random_int(0, $max)];
        }

        /*
         * Implode the pieces and return the random string.
         */
        return implode('', $pieces);
    }

    /**
     * Convert the string to a slug.
     *
     * @param string $string
     */
    public static function slug(string $string): string
    {
        return strtolower(str_replace([' ', '_', '.', '/', '\\'], '-', $string));
    }

    /**
     * Truncate the string.
     *
     * @param string $string
     * @param int $length
     * @return string $string
     */
    public static function truncate(string $string, int $length = 50)
    {
        return substr($string, 0, $length) . '...';
    }
}
