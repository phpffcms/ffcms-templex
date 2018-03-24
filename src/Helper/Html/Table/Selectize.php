<?php

namespace Ffcms\Templex\Helper\Html\Table;

/**
 * Class Selectize. Selectize special features
 * @package Ffcms\Templex\Helper\Html\Table
 */
class Selectize implements RenderElement
{
    private $order = -1;
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
     * Render necessary html/css code
     * @return null|string
     */
    public function html(): ?string
    {
        return '<script>
        var selectize_' . $this->name . ' = document.getElementsByName("' . $this->name . '[]");
        document.getElementsByName("' . $this->name . 'All")[0].addEventListener("change", function() {
            for (var i = 0; i < selectize_' . $this->name . '.length; i++) {
                selectize_' . $this->name . '[i].checked = this.checked;
            } 
        });
        </script>';
    }
}
