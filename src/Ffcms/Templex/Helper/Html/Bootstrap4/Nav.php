<?php

namespace Ffcms\Templex\Helper\Html\Bootstrap4;


use Ffcms\Templex\Helper\Html\Listing;
use League\Plates\Engine;

/**
 * Class Nav. Build basic nav
 * @package Ffcms\Templex\Helper\Html\Bootstrap4
 */
class Nav extends Listing
{
    /**
     * Initialize nav instance
     * @param string $type
     * @param array|null $properties
     * @return Nav
     */
    public static function factory(string $type, ?array $properties = null): self
    {
        // add bootstrap 4 class
        $properties['class'] = 'nav ' . $properties['class'];

        $instance = new self();
        $instance->type = $type;
        $instance->properties = $properties;
        return $instance;
    }

    /**
     * Register extension in plates.
     * @param Engine $engine
     */
    public function register(Engine $engine)
    {
        $this->engine = $engine;
        $this->engine->registerFunction('nav', [$this, 'factory']);
    }

    /**
     * Add menu item
     * @param array|callable $context
     * @param array|null $properties
     * @return Nav
     */
    public function menu($context, ?array $properties = null): self
    {
        if (is_callable($context)) {
            $context = $context();
        }

        if (is_array($context)) {
            if (isset($context['tab'])) {

            } else {
                $context['urlEqual'] = true;
                if (!isset($properties['class'])) {
                    $properties['class'] = 'nav-item';
                }
                if (!isset($context['linkProperties']['class'])) {
                    $context['linkProperties']['class'] = 'nav-link';
                }

                $this->li[] = new Listing\Li($context, $properties);
            }
        }

        return $this;
    }
}