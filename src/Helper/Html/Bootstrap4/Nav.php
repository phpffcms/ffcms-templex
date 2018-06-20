<?php

namespace Ffcms\Templex\Helper\Html\Bootstrap4;

use Ffcms\Templex\Helper\Html\Dom;
use Ffcms\Templex\Helper\Html\Listing;
use League\Plates\Engine;

/**
 * Class Nav. Build basic nav
 * @package Ffcms\Templex\Helper\Html\Bootstrap4
 */
class Nav extends Listing
{
    private $id;
    private $tabIndex = 0;

    private $tabContent;

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
        $instance->id = $properties['id'] ?? 'nav-auto-' . mt_rand(0, 1000000);
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
        if (is_callable($context) && !is_string($context)) {
            $context = $context();
        }

        if (is_array($context)) {
            // process tab properties
            if (isset($context['tab'])) {
                $this->properties['role'] = 'tablist';
                $this->properties['id'] = $this->id . '-tab';
                $context['link'] = ['#' . $this->id . '-' . $this->tabIndex];

                $context['linkProperties']['id'] = $this->id . '-' . $this->tabIndex . '-tab';
                $context['linkProperties']['data-toggle'] = 'tab';
                $context['linkProperties']['role'] = 'tab';

                if (is_callable($context['tab']) && !is_string($context['tab'])) {
                    $context['tab'] = $context['tab']();
                }
                // build tab content html code
                $this->tabContent .= (new Dom())->div(function () use ($context) {
                    return $context['tab'];
                }, ['class' => 'tab-pane ' . (!$this->tabContent ? 'active show' : 'fade'), 'id' => $this->id . '-' . $this->tabIndex, 'role' => 'tabpanel']);

                $this->tabIndex++;
            } else {
                $context['urlEqual'] = true;
            }

            // build menu element and define default properties
            if (!isset($properties['class'])) {
                $properties['class'] = 'nav-item';
            }
            if (!isset($context['linkProperties']['class'])) {
                $context['linkProperties']['class'] = 'nav-link';
                if (!$this->li) {
                    $context['linkProperties']['class'] .= ' active';
                }
            }

            $this->li[] = new Listing\Li($context, $properties);
        }

        return $this;
    }

    /**
     * Add tab content for listings
     * @return null|string
     */
    public function display(): ?string
    {
        $html = parent::display();
        if ($this->tabIndex > 0) {
            $html .= (new Dom())->div(function () {
                return $this->tabContent;
            }, ['class' => 'tab-content', 'id' => $this->id . '-tabContent']);
        }
        return $html;
    }
}
