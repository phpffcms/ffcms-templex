<?php

namespace Ffcms\Templex\Helper\Html\Bootstrap4;

use Ffcms\Templex\Helper\Html\Dom;
use Ffcms\Templex\Helper\Html\Listing;
use Ffcms\Templex\Url\Url;
use Ffcms\Templex\Url\UrlRepository;

/**
 * Class Navbar. Build bootstrap navbar
 * @package Ffcms\Templex\Helper\Html\Bootstrap4
 */
class Navbar
{
    private $id;

    private $properties;
    private $container = false;

    // left & right ul*li elements array of items
    private $left = [];
    private $right = [];
    // brand item
    private $brand;

    private $dropdownCounter = 1;

    /**
     * Navbar constructor.
     * @param array|null $properties
     * @param bool $container
     */
    public function __construct(?array $properties = null, bool $container = false)
    {
        $this->properties = $properties;
        $this->container = $container;

        $this->properties['class'] = 'navbar ' . ($this->properties['class'] ?? null);
    }

    /**
     * Navbar factory entry point. Build instance of navbar
     * @param array|null $properties
     * @param bool $container
     * @return Navbar
     */
    public static function factory(?array $properties = null, bool $container = false): Navbar
    {
        return new self($properties, $container);
    }

    /**
     * Set navbar global id for collapse and other things binding
     * @param string $name
     * @return Navbar
     */
    public function id(string $name): Navbar
    {
        $this->id = $name;
        return $this;
    }

    /**
     * Add menu element
     * @param string $pos
     * @param array $item
     * @return Navbar
     */
    public function menu(string $pos = 'left', array $item): Navbar
    {
        if (!in_array($pos, ['left', 'right']) || !isset($item['text'])) {
            return $this;
        }

        // set default menu class
        $item['properties']['class'] = 'nav-item ' . ($item['properties']['class'] ?? null);
        $item['linkProperties']['class'] = 'nav-link ' . ($item['linkProperties']['class'] ?? null);

        $this->{$pos}[] = $item;
        return $this;
    }

    /**
     * Set brand item
     * @param array $item
     * @return Navbar
     */
    public function brand(array $item): Navbar
    {
        $this->brand = $item;
        return $this;
    }

    /**
     * Get navbar result output html code
     * @return null|string
     */
    public function display(): ?string
    {
        if (count($this->left) < 1 && count($this->right) < 1) {
            return null;
        }
        // set automatic id if not defined
        if (!$this->id || !is_string($this->id)) {
            $this->id = 'navid-auto-' . mt_rand(0, 1000000);
        }

        // build navbar output html
        return (new Dom())->nav(function () {
            $html = null;
            // compile brand if exist
            if ($this->brand && isset($this->brand['text'])) {
                if (!isset($this->brand['link'])) {
                    $this->brand['link'] = ['#'];
                }
                // build brand url if defined
                $link = Url::link($this->brand['link']);
                $html .= (new Dom())->a(function () {
                    return htmlentities($this->brand['text'], null, 'UTF-8');
                }, ['href' => $link, 'class' => 'navbar-brand']);
            }
            // add toggle trigger button for mobile/tablets grid view
            $html .= $this->buildToggleButton();

            // add navbar menus
            $html .= (new Dom())->div(function () {
                return $this->buildListing('left') . $this->buildListing('right');
            }, ['class' => 'collapse navbar-collapse', 'id' => $this->id]);

            // check if container <div> should be implemented
            if ($this->container) {
                $html = (new Dom())->div(function () use ($html) {
                    return $html;
                }, ['class' => 'container']);
            }

            return $html;
        }, $this->properties);
    }

    /**
     * Draw toggle button for sm/xs devices view
     * @return null|string
     */
    private function buildToggleButton(): ?string
    {
        return (new Dom())->button(function () {
            return (new Dom())->span(['class' => 'navbar-toggler-icon']);
        }, ['class' => 'navbar-toggler',
            'type' => 'button',
            'data-toggle' => "collapse",
            'data-target' => '#' . $this->id,
            'aria-controls' => $this->id,
            'aria-expanded' => 'false',
            'aria-label' => 'Toggle navigation'
        ]);
    }

    /**
     * Build menu listings
     * @param string $pos
     * @return null|string
     */
    private function buildListing(string $pos): ?string
    {
        // do not process if empty or 0 elements
        if (!property_exists($this, $pos) || !is_array($this->{$pos}) || count($this->{$pos}) < 1) {
            return null;
        }
        $class = ($pos === 'right' ? 'ml-auto' : 'mr-auto');
        $listing = Listing::factory('ul', ['class' => 'navbar-nav ' . $class]);
        foreach ($this->{$pos} as $item) {
            if (isset($item['dropdown'])) {
                $item = $this->prepareDropDown($item);
            }
            $listing->li($item, $item['properties']);
        }

        return $listing->display();
    }

    /**
     * Prepare dropdown attributes
     * @param array $item
     * @return array|null
     */
    private function prepareDropDown(array $item): ?array
    {
        // set automatic id if not defined
        if (!$this->id || !is_string($this->id)) {
            $this->id = 'navid-auto-' . mt_rand(0, 1000000);
        }

        $item['properties']['class'] .= ' dropdown';
        $item['properties']['anchor'] = [
            'class' => 'nav-link dropdown-toggle',
            'href' => '#',
            'id' => $this->id . '-' . $this->dropdownCounter,
            'data-toggle' => 'dropdown',
            'aria-haspopup' => 'true',
            'aria-expanded' => 'false'
        ];
        $item['properties']['container']['class'] = 'dropdown-menu';
        // add class="dropdown-item" for elements in dropdown
        foreach ($item['dropdown'] as $idx => $dd) {
            if (!isset($dd['class'])) {
                $item['dropdown'][$idx]['class'] = 'dropdown-item';
            }
        }

        $this->dropdownCounter++;
        return $item;
    }

    public function __toString()
    {
        return $this->display();
    }
}
