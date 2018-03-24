<?php

namespace Ffcms\Templex\Helper\Html\Form\Field;

use Ffcms\Templex\Helper\Html\Form\ModelInterface;


/**
 * Class StandardField. Standard field implementation
 * @package Ffcms\Templex\Helper\Html\Form\Field
 */
abstract class StandardField implements FieldInterface
{
    protected $model;
    protected $fieldName;

    protected $value;

    protected $attrName;
    protected $fieldNameWithForm;

    /**
     * StandardField constructor.
     * @param ModelInterface $model
     * @param string $fieldName
     */
    public function __construct(ModelInterface $model, string $fieldName)
    {
        $this->model = $model;
        $this->fieldName = $fieldName;

        $this->processInit();
    }

    /**
     * Set default conditions and names
     * @return void
     */
    private function processInit(): void
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

    /**
     * Get field id="" or name="" valid attribute value
     * @return string|null
     */
    public function getUniqueNameId()
    {
        return $this->fieldNameWithForm;
    }
}