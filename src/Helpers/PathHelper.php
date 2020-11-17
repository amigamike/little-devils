<?php

/**
 * Path helper.
 *
 * @package     MikeWelsh\LittleDevils\Helpers\PathHelper
 * @author      Mike Welsh (mike@amigamike.com)
 * @copyright   2020 Mike Welsh
 */

namespace MikeWelsh\LittleDevils\Helpers;

class PathHelper
{
    /**
     * Path.
     * @var array
     */
    private static $path = [];

    private static function buildPath()
    {
        self::$path = parse_url($_SERVER['REQUEST_URI']);
    }

    /**
     * Get the full path.
     *
     * @return string
     */
    public static function getFullPath()
    {
        return $_SERVER['REQUEST_URI'];
    }

    /**
     * Get the path.
     *
     * @return string
     */
    public static function getPath()
    {
        self::buildPath();

        return rtrim(self::$path['path'], '/');
    }

    /**
     * Get the query.
     *
     * @return array
     */
    public static function getQuery()
    {
        self::buildPath();

        parse_str(self::$path['query'], $query);
        
        return $query;
    }
}
