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
use Ffcms\Templex\Template\Template;

/**
 * Class Template. Template engine loader entry point.
 * @package Ffcms\Templex
 */
class Engine extends \League\Plates\Engine
{

    private $defaultDirectory;

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

    /**
     * Create a new template and render it.
     * @param string $name
     * @param array $data
     * @param null $fallbackDir
     * @return string
     */
    public function render($name, array $data = array(), $fallbackDir = null)
    {
        try {
            $render = parent::render($name, $data);
        } catch (\Exception $e) {
            if ($fallbackDir && Directory::exist($fallbackDir)) {
                // try to use fallback directory if exception catched
                $currentDir = $this->getDirectory();
                $this->setDirectory($fallbackDir);
                try {
                    $render = parent::render($name, $data);
                } catch (\Exception $e) {
                    $this->setDirectory($currentDir);
                    Error::add($e->getMessage(), __FILE__);
                }
            }
        }

        // fix override work directory by fallback dir
        if ($fallbackDir && $this->getDirectory() === $fallbackDir) {
            $this->setDirectory($this->defaultDirectory);
        }

        return $render;
    }
}
