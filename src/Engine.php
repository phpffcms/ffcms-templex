<?php

namespace Ffcms\Templex;

use Ffcms\Templex\Helper\Html\Bootstrap4;
use Ffcms\Templex\Helper\Html\Form;
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
            new Bootstrap4()
        ]);
    }
}
