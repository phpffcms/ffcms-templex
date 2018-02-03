<?php

namespace Ffcms\Templex\Helper\Html;

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
    public static function factory(array $p = null)
    {
        $instance = new self();
        $instance->tableProperties = $p;
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
    public function thead(?array $properties = null, $items): Table
    {
        // sounds like closure? execute it and get result )
        if (is_callable($items)) {
            $items = $items();
        }

        // check if thead defined and titles are iterable
        if (is_iterable($items)) {
            // throw exception
            $this->thead = new Thead($properties, $items);
            if ($this->selectize) {
                $this->thead->initSelectize($this->selectize);
            }

            if ($this->sorter) {
                $this->thead->initSorter($this->sorter);
            }
        }

        return $this;
    }

    /**
     * Build tbody section
     * @param array|null $properties
     * @param array|\Closure $items
     * @return Table
     */
    public function tbody(?array $properties = null, $items): Table
    {
        if (is_callable($items)) {
            $items = $items();
        }

        // check if array given and process items
        if (is_iterable($items)) {
            $this->tbody = new Tbody($properties, $items);
            if ($this->selectize) {
                $this->tbody->initSelectize($this->selectize);
            }
        }

        return $this;
    }

    /**
     * Add selectable checkbox for $order with input name $name
     * @param string $order
     * @param string $name
     */
    public function selectize(int $order, string $name): Table
    {
        $this->selectize = new Selectize($order, $name);
        return $this;
    }

    /**
     * Initialize sorter
     * @param array $columnNumbers
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
            return null;
        }

        $table = (new Dom())->table(function() {
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