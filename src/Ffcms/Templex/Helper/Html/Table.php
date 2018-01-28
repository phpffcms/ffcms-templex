<?php

namespace Ffcms\Templex\Helper\Html;


class Table
{
    private $tableProperties;
    private $dom;

    private $thead;
    private $tbody;
    private $table;

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

        // @todo: parse items & properties and build thead html code in $this->thead

        return $this;
    }

    public function display()
    {
        // @todo: build output html table
    }
}