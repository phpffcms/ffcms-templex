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

        return (new Dom())->div(function() use ($text, $html) {
            if (!$html) {
                $text = htmlspecialchars($text, null, 'UTF-8');
            }
            return $text;
        }, ['class' => 'alert alert-' . $type]);
    }

    public function badge(string $type, string $text)
    {

    }

    /**
     * Build navbar instance controller
     * @param array|null $properties
     * @param bool $container
     * @return Navbar
     */
    public function navbar(?array $properties = null, bool $container = false)
    {
        return Navbar::factory($properties, $container);
    }

}