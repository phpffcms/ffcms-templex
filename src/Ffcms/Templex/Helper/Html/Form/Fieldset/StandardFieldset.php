<?php

namespace Ffcms\Templex\Helper\Html\Form\Fieldset;

use Ffcms\Templex\Engine;
use Ffcms\Templex\Helper\Html\Form\ModelInterface;

/**
 * Class StandardField.
 * @package Ffcms\Templex\Helper\Form\Field
 */
abstract class StandardFieldset implements FieldsetInterface
{
    protected $model;
    protected $fieldName;
    protected $engine;

    /**
     * DefaultField constructor.
     * @param ModelInterface $model
     * @param string $fieldName
     * @param Engine $engine
     */
    public function __construct(ModelInterface $model, string $fieldName, Engine $engine)
    {
        $this->model = $model;
        $this->fieldName = $fieldName;
        $this->engine = $engine;

        $this->before();
    }

    // before method to prevent override __construct
    protected function before(){}
}
