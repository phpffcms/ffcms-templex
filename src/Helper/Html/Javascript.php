<?php

namespace Ffcms\Templex\Helper\Html;


use League\Plates\Engine;
use League\Plates\Extension\ExtensionInterface;

/**
 * Class Javascript. Plate framework extension
 * @package Ffcms\Templex\Helper\Html
 */
class Javascript implements ExtensionInterface
{
    protected static $instance;

    /** @var Engine */
    protected static $engine;

    /**
     * Register plate extension
     * @param Engine $engine
     */
    public function register(Engine $engine)
    {
        self::$engine = $engine;
        $engine->registerFunction('javascript', [$this, 'factory']);
    }

    /**
     * Build factory (return current state)
     * @return Javascript
     */
    public function factory(): Javascript
    {
        return $this;
    }

    /**
     * Make selection & change header location with query data from form selectize
     * @param string $selector
     * @param string $queryName
     * @param string $text
     * @param array $url
     * @param array|null $properties
     * @return string
     */
    public function submitSelectizeTable(string $selector, string $queryName, string $text, array $url, ?array $properties = null)
    {
        return self::$engine->render('_core/javascript/submit_selectize_table', [
            'selector' => $selector,
            'query' => $queryName,
            'text' => $text,
            'url' => $url,
            'properties' => $properties
        ]);
    }
}