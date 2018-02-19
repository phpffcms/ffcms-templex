<?php

namespace Ffcms\Templex\Helper\Html;

use Ffcms\Templex\Exceptions\Error;
use Ffcms\Templex\Helper\Html\Listing\Li;
use League\Plates\Engine;
use League\Plates\Extension\ExtensionInterface;

/**
 * Class Listing. Simple create ul*li lists.
 * @package Ffcms\Templex\Helper\Html
 */
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
    public static function factory(string $type, ?array $properties = null): Listing
    {
        $instance = new self();
        $instance->type = $type;
        $instance->properties = $properties;
        return $instance;
    }

    /**
     * Build <li><li> from items array
     * @param array|\Closure $items
     * @return Listing
     */
    public function li($items): Listing
    {
        // make closure call
        if (is_callable($items)) {
            $items = $items();
        }

        if (is_iterable($items)) {
            $this->li = new Li($items);
        }

        return $this;
    }

    /**
     * Display output html code
     * @return null|string
     */
    public function display(): ?string
    {
        return (new Dom())->{$this->type}(function () {
            if (!$this->li) {
                Error::add('No items to display in listing', __FILE__);
                return null;
            }
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
