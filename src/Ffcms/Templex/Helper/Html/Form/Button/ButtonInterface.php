<?php

namespace Ffcms\Templex\Helper\Html\Form\Button;

use League\Plates\Engine;

interface ButtonInterface
{
    /**
     * ButtonInterface constructor.
     * @param Engine $engine
     */
    public function __construct(Engine $engine);

    /**
     * @param string $text
     * @param array|null $properties
     * @return null|string
     */
    public function html(string $text, ?array $properties = null): ?string ;
}
