<?php

namespace Ffcms\Templex\Exceptions;

/**
 * Class Error. Serve error messages
 * @package Ffcms\Templex\Exceptions
 */
class Error
{
    private static $logs;

    /**
     * Add log message by file
     * @param string $message
     * @param string $file
     * @return void
     */
    public static function add(string $message, string $file): void
    {
        static::$logs[$file][] = $message;
    }

    /**
     * Get all logs
     * @return array|null
     */
    public static function all(): ?array
    {
        return static::$logs;
    }
}
