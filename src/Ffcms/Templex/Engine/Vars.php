<?php

namespace Ffcms\Templex\Engine;


/**
 * Class Vars. Save global template variables inside singleton holder
 * @package Ffcms\Templex\Engine
 */
class Vars
{
    private static $inst;

    protected $globalVars = [];

    /**
     * Singleton holder
     * @return Vars
     */
    public static function instance()
    {
        if (!self::$inst) {
            self::$inst = new self();
        }

        return self::$inst;
    }

    /**
     * Set global variable for Views
     * @param string $var
     * @param string|array $value
     * @param bool $html
     */
    public function setGlobal($var, $value, $html = false): void
    {
        $this->globalVars[$var] = $html ? $value : htmlspecialchars($value);
    }

    /**
     * Set global variable from key=>value array (key = varname)
     * @param array $array
     */
    public function setGlobalArray(array $array): void
    {
        foreach ($array as $var => $value) {
            $this->globalVars[$var] = $value;
        }
    }

    /**
     * Get all global variables as array
     * @return array|null
     */
    public function getGlobalsArray(): ?array
    {
        return $this->globalVars;
    }

    /**
     * Get all global variables as stdObject
     * @return object
     */
    public function getGlobalsObject()
    {
        return (object)$this->globalVars;
    }

    /**
     * Check if global variable isset
     * @param string $var
     * @return bool
     */
    public function issetGlobal($var)
    {
        return array_key_exists($var, $this->globalVars);
    }

}