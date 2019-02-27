<?php

namespace Ffcms\Templex\Template;


/**
 * Class Fallbacks. Process fallback template directories. Allow use multiple template directories for php_plates.
 * @package Ffcms\Templex\Template
 */
class Fallbacks
{
    protected $dirs = [];

    /**
     * Add template fallback full path from root
     * @param string $path
     */
    public function add(string $path)
    {
        if (!in_array($path, $this->dirs) && $this->exist($path)) {
            $this->dirs[] = $path;
        }
    }

    /**
     * Check if directory is exist
     * @param string $path
     * @return bool
     */
    public function exist(string $path)
    {
        return is_dir($path) && is_readable($path);
    }

    /**
     * Get all fallback directories. Latest added directory is newest
     * @return array
     */
    public function get(): array
    {
        return $this->dirs;
    }


}