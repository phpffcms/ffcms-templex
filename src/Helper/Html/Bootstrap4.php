<?php

namespace Ffcms\Templex\Helper\Html;

use Ffcms\Templex\Helper\Html\Bootstrap4\Nav;
use Ffcms\Templex\Helper\Html\Bootstrap4\Navbar;
use League\Plates\Engine;
use League\Plates\Extension\ExtensionInterface;

/**
 * Class Bootstrap4. Bootstrap 4 html builder instance
 * @package Ffcms\Templex\Helper\Html
 */
class Bootstrap4 implements ExtensionInterface
{
    const CSS_TYPES = [
        'primary', 'secondary', 'success', 'danger', 'warning', 'info', 'light', 'dark'
    ];

    public static $engine;

    protected static $instance;

    /**
     * @param Engine $engine
     */
    public function register(Engine $engine)
    {
        self::$engine = $engine;
        $engine->registerFunction('bootstrap', [$this, 'factory']);
    }

    /**
     * Entry point method
     * @return Bootstrap4
     */
    public static function factory(): Bootstrap4
    {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Build simple navigation
     * @param string $type
     * @param array|null $properties
     * @return Nav
     */
    public function nav(string $type, ?array $properties = null): Nav
    {
        return Nav::factory($type, $properties);
    }

    /**
     * Build alert notification
     * @param string $type
     * @param string $text
     * @param bool $html
     * @return string
     */
    public function alert(string $type, string $text, bool $html = false): ?string
    {
        if (!in_array($type, static::CSS_TYPES, true)) {
            return null;
        }

        return (new Dom())->div(function () use ($text, $html){
            if (!$html) {
                $text = htmlspecialchars($text);
            }

            $text .= (new Dom())->button(function(){
                return '';
            }, ['type' => 'button', 'class' => 'btn-close', 'data-bs-dismiss' => 'alert', 'aria-label' => 'Close']);

            return $text;
        }, ['class' => 'alert alert-' . $type . ' alert-dismissible fade show', 'role' => 'alert']);
    }

    /**
     * Build badge item
     * @param string $type
     * @param string $text
     * @return null|string
     */
    public function badge(string $type, string $text): ?string
    {
        if (!in_array($type, static::CSS_TYPES, true)) {
            return null;
        }

        return (new Dom())->span(function () use ($text) {
            return htmlspecialchars($text);
        }, ['class' => 'badge badge-' . $type]);
    }

    /**
     * Build buttom dom
     * @param string $type
     * @param string $text
     * @param array|null $properties
     * @return null|string
     */
    public function button(string $type, string $text, ?array $properties = null): ?string
    {
        // check if button is <input />, <button></button> or <a></a> type
        if (!in_array($type, ['input', 'button', 'a'], true)) {
            return null;
        }

        if ($type === 'button') {
            $properties['type'] = 'button';
        } elseif ($type === 'input') {
            $properties['value'] = htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
            if (!isset($properties['type'])) {
                $properties['type'] = 'submit';
            }
        }

        $properties['class'] = 'btn ' . $properties['class'];
        return (new Dom())->{$type}(function () use ($text, $type, $properties) {
            if ($type === 'input') {
                return null;
            }
            return htmlspecialchars($text);
        }, $properties);
    }

    /**
     * Build navbar instance controller
     * @param array|null $properties
     * @param bool $container
     * @return Navbar
     */
    public function navbar(?array $properties = null, bool $container = false): Navbar
    {
        return Navbar::factory($properties, $container);
    }

    /**
     * Build pagination instance
     * @param array $url
     * @param array|null $properties
     * @param array|null $liProperties
     * @param array|null $aProperties
     * @return Pagination
     */
    public function pagination(array $url, ?array $properties = null, ?array $liProperties = null, ?array $aProperties = null): Pagination
    {
        return Bootstrap4\Pagination::factory($url, $properties, $liProperties, $aProperties);
    }

    /**
     * Build bootstrap button group
     * @param array|null $properties
     * @param int $dropdownLimit
     * @return Bootstrap4\ButtonGroup
     */
    public function btngroup(?array $properties = null, int $dropdownLimit = 3)
    {
        return Bootstrap4\ButtonGroup::factory($properties, $dropdownLimit);
    }
}
