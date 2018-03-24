<?php

namespace Ffcms\Templex\Helper\Html;

use Ffcms\Templex\Exceptions\Error;
use Ffcms\Templex\Helper\Html\Listing\Li;
use League\Plates\Engine;
use League\Plates\Extension\ExtensionInterface;

/**
 * Class Listing. Simple create ul*li lists.
 * @package Ffcms\Templex\Helper\Html
 */
class Listing implements ExtensionInterface
{
    protected $engine;

    protected $type;
    protected $properties;

    /** @var Li[]|null */
    protected $li;

    /**
     * Register extension in plates.
     * @param Engine $engine
     */
    public function register(Engine $engine)
    {
        $this->engine = $engine;
        $this->engine->registerFunction('listing', [$this, 'factory']);
    }

    /**
     * Build listing instance
     * @param string $type
     * @param array|null $properties
     * @return self
     */
    public static function factory(string $type, ?array $properties = null)
    {
        $instance = new self();
        $instance->type = $type;
        $instance->properties = $properties;
        return $instance;
    }

    /**
     * @param array|string $context
     * @param array|null $properties
     * @return Listing
     */
    public function li($context, ?array $properties = null): self
    {
        if (is_callable($context)) {
            $context = $context();
        }

        $this->li[] = new Li($context, $properties);
        return $this;
    }

    /**
     * Display output html code
     * @return null|string
     */
    public function display(): ?string
    {
        return (new Dom())->{$this->type}(function () {
            if (!$this->li) {
                Error::add('No items to display in listing', __FILE__);
                return null;
            }
            $html = null;
            foreach ($this->li as $li) {
                $html .= $li->html();
            }
            return $html;
        }, $this->properties);
    }

    /**
     * @return null|string
     */
    public function __toString(): ?string
    {
        return $this->display();
    }
}
