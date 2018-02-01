<?php

namespace Ffcms\Templex\Helper\Html;


use Ffcms\Templex\Helper\Html\Listing\Li;

class Listing implements HelperInterface
{
    private $type;
    private $properties;

    /** @var Li */
    private $li;

    /**
     * Listing constructor.
     * @param string $type
     * @param array|null $properties
     */
    public function __construct(string $type, ?array $properties = null)
    {
        $this->type = $type;
        $this->properties = $properties;
    }

    /**
     * Build listing instance
     * @param string $type
     * @param array|null $properties
     * @return Listing
     */
    public static function factory(string $type, ?array $properties = null)
    {
        return new self($type, $properties);
    }

    /**
     * @param array|null $properties
     * @param array|\Closure $items
     */
    public function li(?array $properties = null, $items)
    {
        // make closure call
        if (is_callable($items)) {
            $items = $items();
        }

        if (is_iterable($items)) {
            $this->li = new Li($items, $this->type);
        }

        return $this;
    }

    /**
     * Display output html code
     * @return null|string
     */
    public function display(): ?string
    {
        return (new Dom())->{$this->type}(function() {
            return $this->li->html();
        }, $this->properties);
    }

}