<?php

namespace Ffcms\Templex\Helper\Html\Form\Field;

use Ffcms\Templex\Engine;
use Ffcms\Templex\Helper\Html\Form\ModelInterface;

/**
 * Class StandardField.
 * @package Ffcms\Templex\Helper\Form\Field
 */
abstract class StandardField implements FieldInterface
{
    protected $model;
    protected $fieldName;
    protected $engine;

    protected $value;

    protected $attrName;
    protected $fieldNameWithForm;

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

        // make default post-processing
        $this->processDefault();
    }

    /**
     * Process attribute/param naming logic and get value from model
     */
    private function processDefault()
    {
        $full = $this->fieldName;
        $attr = $full;
        // check if dot notation used and get short name of root element
        if (strpos($full, '.')) {
            $attr = strstr($attr, '.', true);
        };

        // check if model has property
        if (!property_exists($this->model, $attr)) {
            return;
        }

        $value = $this->model->{$attr};
        // get value if dot notation used for array field
        if ($attr !== $full) {
            $nesting = trim(strstr($full, '.'), '.');
            $attr .= '-' . str_replace('.', '-', $nesting);
            // check if nesting contains dots
            if (strpos($nesting, '.') === false) {
                $value = $value[$nesting];
            } else {
                // multiple array nesting exist
                foreach (explode('.', $nesting) as $path) {
                    $value = $value[$path];
                }
            }
        }

        $this->attrName = $attr;
        $this->fieldNameWithForm = $this->model->getFormName() . '-' . $this->attrName;
        $this->value = $value;
    }
}
