<?php

namespace Ffcms\Templex\Helper\Html;

use Ffcms\Templex\Exceptions\Error;
use Ffcms\Templex\Helper\Html\Table\Selectize;
use Ffcms\Templex\Helper\Html\Table\Sorter;
use Ffcms\Templex\Helper\Html\Table\Tbody;
use Ffcms\Templex\Helper\Html\Table\Thead;
use League\Plates\Engine;
use League\Plates\Extension\ExtensionInterface;

/**
 * Class Table. HTML table code builder
 * @package Ffcms\Templex\Helper\Html
 */
class Table implements ExtensionInterface
{
    private $engine;

    private $tableProperties;

    /** @var Selectize */
    private $selectize;
    private $sorter;

    /** @var Thead */
    private $thead;
    /** @var Tbody */
    private $tbody;

    /**
     * Factory method. Get instance object for new table
     * @param array|null $p
     * @return Table
     */
    public static function factory(array $p = null): Table
    {
        $instance = new self();
        $instance->tableProperties = $p;
        $instance->tbody = new Tbody();
        $instance->thead = new Thead();
        return $instance;
    }

    /**
     * Register table helper
     * @param Engine $engine
     */
    public function register(Engine $engine)
    {
        $this->engine = $engine;
        $this->engine->registerFunction('table', [$this, 'factory']);
    }

    /**
     * Build thead section
     * @param array|null $properties
     * @param $items
     * @return Table
     */
    public function head(?array $properties = null, $items): Table
    {
        // sounds like closure? execute it and get result )
        if (is_callable($items)) {
            $items = $items();
        }

        // pass properties in thead instance
        if ($properties) {
            $this->thead->setProperties($properties);
        }

        // pass thead items
        if (is_array($items)) {
            $this->thead->setItems($items);
        }

        // check if sorter is enabled & initialize it
        if ($this->sorter) {
            $this->thead->initSorter($this->sorter);
        }

        return $this;
    }

    /**
     * Build tbody section
     * @param array|null $properties
     * @param array|\Closure $items
     * @return Table
     */
    public function body(?array $properties = null, $items): Table
    {
        if (is_callable($items)) {
            $items = $items();
        }

        // check if properties is used
        if ($properties) {
            $this->tbody->setProperties($properties);
        }

        // add items into tbody array
        if (is_array($items)) {
            $this->tbody->addItems($items);
        }

        return $this;
    }

    /**
     * Add row in tbody display
     * @param array $item
     * @param int|null $idx
     * @return Table
     */
    public function row(array $item, ?int $idx = null): Table
    {
        $this->tbody->addItem($item, $idx);
        return $this;
    }

    /**
     * Add selectable checkbox for $order with input name $name
     * @param int $order
     * @param string $name
     * @return Table
     */
    public function selectize(int $order, string $name): Table
    {
        $this->selectize = new Selectize($order, $name);
        $this->tbody->initSelectize($this->selectize);
        $this->thead->initSelectize($this->selectize);
        return $this;
    }

    /**
     * Initialize sorter
     * @param array $columns
     * @param string|null $currentUrl
     * @return Table
     */
    public function sortable(array $columns, ?string $currentUrl = null): Table
    {
        $this->sorter = new Sorter($columns, $currentUrl);
        return $this;
    }

    /**
     * Finally display table html code
     * @return null|string
     */
    public function display(): ?string
    {
        // check if tbody is used
        if (!$this->tbody) {
            Error::add('Table failed: no tbody items exist', __FILE__);
            return null;
        }

        $table = (new Dom())->table(function () {
            $thead = $this->thead;
            if ($thead) {
                $thead = $thead->html();
            }

            return $thead . $this->tbody->html();
        }, $this->tableProperties);

        if ($this->selectize) {
            $table .= $this->postProcessJs();
        }
        return $table;
    }

    /**
     * Post render specific javascripts generated by additional features
     * @return null|string
     */
    private function postProcessJs(): ?string
    {
        $code = null;
        if ($this->selectize) {
            $code .= $this->selectize->html();
        }

        return $code;
    }

    /**
     * @return null|string
     */
    public function __toString()
    {
        return $this->display();
    }
}