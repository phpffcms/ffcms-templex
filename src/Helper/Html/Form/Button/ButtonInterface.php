<?php

namespace Ffcms\Templex\Helper\Html\Form\Button;

use Ffcms\Templex\Helper\Html\Form\ModelInterface;
use League\Plates\Engine;

interface ButtonInterface
{
    /**
     * ButtonInterface constructor.
     * @param Engine $engine
     * @param ModelInterface $model
     */
    public function __construct(Engine $engine, ModelInterface $model);

    /**
     * @param string $text
     * @param array|null $properties
     * @return null|string
     */
    public function html(string $text, ?array $properties = null): ?string ;
}
