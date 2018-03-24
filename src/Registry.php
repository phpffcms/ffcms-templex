<?php

namespace Ffcms\Templex;


/**
 * Class Registry. Config and instance registry
 * @package Ffcms\Templex
 */
class Registry
{
    // var storage
    private static $vars;

    /**
     * Set var
     * @param string $key
     * @param $value
     */
    public static function set(string $key, $value)
    {
        self::$vars[$key] = $value;
    }

    /**
     * Get var
     * @param string $key
     * @return mixed
     */
    public static function get(string $key)
    {
        return self::$vars[$key];
    }

    /**
     * Check if key is set
     * @param string $key
     * @return bool
     */
    public static function is(string $key)
    {
        return isset(self::$vars[$key]);
    }

}