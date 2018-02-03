<?php

namespace Ffcms\Templex\Helper\Html;


use Ffcms\Templex\Helper\Html\Listing\Li;
use League\Plates\Engine;
use League\Plates\Extension\ExtensionInterface;

class Listing implements ExtensionInterface
{
    private $engine;

    private $type;
    private $properties;

    /** @var Li */
    private $li;

    /**
     * Register extension in plates.
     * @param Engine $engine
     */
    public function register(Engine $engine)
    {
        $this->engine = $engine;
        $this->engine->registerFunction('listing', [$this, 'factory']);
    }

    /**
     * Build listing instance
     * @param string $type
     * @param array|null $properties
     * @return Listing
     */
    public static function factory(string $type, ?array $properties = null)
    {
        $instance = new self();
        $instance->type = $type;
        $instance->properties= $properties;
        return $instance;
    }

    /**
     * @param array|null $properties
     * @param array|\Closure $items
     */
    public function li(?array $properties = null, $items)
    {
        // make closure call
        if (is_callable($items)) {
            $items = $items();
        }

        if (is_iterable($items)) {
            $this->li = new Li($items, $this->type);
        }

        return $this;
    }

    /**
     * Display output html code
     * @return null|string
     */
    public function display(): ?string
    {
        return (new Dom())->{$this->type}(function() {
            return $this->li->html();
        }, $this->properties);
    }

    /**
     * @return null|string
     */
    public function __toString(): ?string
    {
        return $this->display();
    }
}