<?php

namespace Ffcms\Templex\Template;


use Ffcms\Templex\Engine;

/**
 * Class Name
 * @package Ffcms\Templex\Template
 * @property Engine $engine
 */
class Name extends \League\Plates\Template\Name
{
    private $fallback;

    /**
     * Name constructor. Extend default plates features
     * @param Engine $engine
     * @param string $name
     */
    public function __construct(Engine $engine, string $name)
    {
        parent::__construct($engine, $name);
    }

    /**
     * Extend plates getPath for FFCMS fallback features
     * @return string
     */
    public function getPath()
    {
        // find default path based on Plates logic
        $path = parent::getPath();
        if (is_file($path)) {
            return $path;
        }
        //var_dump($this->file);
        
        // if path not found - try to find path based on FFCMS fallbacks logic
        $dirs = $this->engine->getFallback();
        if (count($dirs) < 1) {
            return $path;
        }
        krsort($dirs);
        foreach ($dirs as $dir) {
            $tmp = $dir . DIRECTORY_SEPARATOR . $this->file;
            if (is_file($tmp)) {
                return $tmp;
            }
        }

        // if nothin found - return default path
        return $path;
    }
}