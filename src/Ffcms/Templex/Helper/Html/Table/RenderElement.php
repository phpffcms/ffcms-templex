<?php

namespace Ffcms\Templex\Helper\Html\Table;


/**
 * Interface RenderElement. Default block interface
 * @package Ffcms\Templex\Helper\Html\Table
 */
interface RenderElement
{
    /**
     * Get html code of render element
     * @return null|string
     */
    public function html(): ?string;
}