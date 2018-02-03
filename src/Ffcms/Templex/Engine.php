<?php

namespace Ffcms\Templex;

use Ffcms\Templex\Helper\Html\Dom;
use Ffcms\Templex\Helper\Html\Listing;
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
}