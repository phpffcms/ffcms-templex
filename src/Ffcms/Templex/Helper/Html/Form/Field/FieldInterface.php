<?php

namespace Ffcms\Templex\Helper\Html\Form\Field;

use Ffcms\Templex\Engine;
use Ffcms\Templex\Helper\Html\Form\ModelInterface;

interface FieldInterface
{
    /**
     * FieldInterface constructor.
     * @param ModelInterface $model
     * @param string $fieldName
     * @param Engine $engine
     */
    public function __construct(ModelInterface $model, string $fieldName, Engine $engine);

    /**
     * Build output html
     * @param array|null $properties
     * @param string|null $helper
     * @return null|string
     */
    public function html(?array $properties = null, ?string $helper = null): ?string;
}
