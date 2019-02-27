<?php

namespace Ffcms\Templex;

use Ffcms\Core\Helper\FileSystem\Directory;
use Ffcms\Templex\Exceptions\Error;
use Ffcms\Templex\Helper\Html\Bootstrap4;
use Ffcms\Templex\Helper\Html\Form;
use Ffcms\Templex\Helper\Html\Javascript;
use Ffcms\Templex\Helper\Html\Listing;
use Ffcms\Templex\Helper\Html\Pagination;
use Ffcms\Templex\Helper\Html\Table;
use Ffcms\Templex\Template\Fallbacks;
use Ffcms\Templex\Template\Template;

/**
 * Class Template. Template engine loader entry point.
 * @package Ffcms\Templex
 */
class Engine extends \League\Plates\Engine
{
    private $defaultDirectory;
    protected $fallbacks;

    /**
     * Engine constructor.
     * @param string|null $directory
     * @param string $fileExtension
     */
    public function __construct(?string $directory = null, string $fileExtension = 'php')
    {
        parent::__construct($directory, $fileExtension);
        $this->fallbacks = new Fallbacks();
        $this->fallbacks->add($directory);
    }

    /**
     * Add fallback directory
     * @param string $dir
     */
    public function addFallback(string $dir)
    {
        $this->fallbacks->add($dir);
    }

    /**
     * Get result fallback paths array
     * @return array
     */
    public function getFallback(): array
    {
        return $this->fallbacks->get();
    }


    /**
     * Override template instance builder
     * @param string $name
     * @return \League\Plates\Template\Template
     */
    public function make($name)
    {
        return new Template($this, $name);
    }

    /**
     * Load default extensions
     */
    public function loadDefaultExtensions(): void
    {
        $this->loadExtensions([
            new Listing(),
            new Table(),
            new Pagination(),
            new Form(),
            new Bootstrap4(),
            new Javascript()
        ]);
        // save default directory for fallback override
        $this->defaultDirectory = $this->getDirectory();
    }
}
