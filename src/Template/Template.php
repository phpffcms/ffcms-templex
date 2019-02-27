<?php

namespace Ffcms\Templex\Template;

use Ffcms\Templex\Helper\Html\Bootstrap4;
use Ffcms\Templex\Helper\Html\Form\ModelInterface;
use Ffcms\Templex\Helper\Html\Javascript;
use Ffcms\Templex\Helper\Html\Table;
use Ffcms\Templex\Helper\Html\Listing;
use Ffcms\Templex\Helper\Html\Pagination;
use Ffcms\Templex\Helper\Html\Form;
use Ffcms\Templex\Engine;

/**
 * Class Template. Extend default template core
 * @package Ffcms\Templex\Template
 * @method Table table(?array $properties = null)
 * @method Listing listing(string $type, ?array $properties = null)
 * @method Pagination pagination(array $url, ?array $properties = null, ?array $linkProperties = null)
 * @method Form form(ModelInterface $model, ?array $properties = null)
 * @method Bootstrap4 bootstrap()
 * @method Javascript javascript()
 */
class Template extends \League\Plates\Template\Template
{
    /**
     * Template constructor. Override init instances
     * @param Engine $engine
     * @param string $name
     */
    public function __construct(Engine $engine, string $name)
    {
        $this->engine = $engine;
        $this->name = new Name($engine, $name);

        $this->data($this->engine->getData($name));
    }
}
