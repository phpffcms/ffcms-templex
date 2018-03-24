<?php

namespace Ffcms\Templex\Helper\Html\Form\Field;


use Ffcms\Templex\Helper\Html\Form\ModelInterface;

/**
 * Interface FieldInterface.
 * @package Ffcms\Templex\Helper\Html\Form\Field
 */
interface FieldInterface
{
    /**
     * FieldInterface constructor.
     * @param ModelInterface $model
     * @param string $fieldName
     */
    public function __construct(ModelInterface $model, string $fieldName);

    /**
     * Build output html
     * @param array|null $properties
     * @return null|string
     */
    public function html(?array $properties = null): ?string;
}