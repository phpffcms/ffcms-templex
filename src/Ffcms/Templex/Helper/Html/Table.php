<?php

namespace Ffcms\Templex\Helper\Html;

use Ffcms\Templex\Helper\Html\Table\Thead;


class Table
{
    private $tableProperties;

    private $dom;

    /** @var Thead */
    private $thead;
    private $tbody;

    /**
     * Table constructor. Pass table properties inside
     * @param array|null $properties
     */
    public function __construct(array $properties = null)
    {
        $this->tableProperties = $properties;
        $this->dom = new Dom();
    }

    /**
     * Get instance of new table
     * @param array|null $p
     * @return Table
     */
    public static function factory(array $p = null)
    {
        return new self($p);
    }

    public function thead(array $properties = null, $items): Table
    {
        // sounds like closure? execute it and get result )
        if (is_callable($items)) {
            $items = $items();
        }

        // check if thead defined and titles are iterable
        if (is_iterable($items)) {
            // throw exception
            $this->thead = new Thead($properties, $items);
        }

        return $this;
    }

    public function display()
    {
        return '';
        // @todo: build output html table
    }
}