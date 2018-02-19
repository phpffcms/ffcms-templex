<?php

namespace Ffcms\Templex\Helper\Html\Table;

/**
 * Class Selectize. Selectize special features
 * @package Ffcms\Templex\Helper\Html\Table
 */
class Selectize implements RenderElement
{
    private $order;
    private $name;

    public function __construct(int $order, string $name)
    {
        $this->order = $order;
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function order()
    {
        return $this->order;
    }

    /**
     * Check if selectize features is passed and enabled
     * @return bool
     */
    public function enabled()
    {
        return ($this->order >= 0 && strlen($this->name) > 0);
    }

    /**
     * Render necessery html/css code
     * @return null|string
     */
    public function html(): ?string
    {
        return '<script>$(document).ready(function(){
        var boxes = $(\'input[name="' . $this->name . '[]"]\');
        $("input[name=' . $this->name . 'All]").change(function(){
            $(boxes).each(function(){
               $(this).prop("checked", !$(this).is(":checked")); 
            });
        });
    });</script>';
    }
}
