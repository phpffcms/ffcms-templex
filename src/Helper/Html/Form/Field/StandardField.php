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

    protected $formFieldName;
    protected $formFieldId;

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
            $name = '[' . $attr . '][' . str_replace('.', '][', $nesting) . ']';
            $attr .= '-' . str_replace('.', '-', $nesting);
            // check if nesting contains dots
            if (strpos($nesting, '.') === false) {
                if (is_array($value)) {
                    $value = $value[$nesting];
                }
            } else {
                // multiple array nesting exist
                foreach (explode('.', $nesting) as $path) {
                    $value = $value[$path];
                }
            }
            $this->formFieldName = $this->model->getFormName() . $name;
        } else {
            $this->formFieldName = $this->model->getFormName() . '[' . $attr . ']';
        }

        $this->formFieldId = $this->model->getFormName() . '-' . $attr;

        $this->attrName = $attr;
        $this->value = $value;
    }

    /**
     * Get field id="" valid attribute value
     * @return string|null
     */
    public function getUniqueFieldId(): ?string
    {
        return $this->formFieldId;
    }

    /**
     * Get field name="" attribute value
     * @return string|null
     */
    public function getUniqueFieldName(): ?string
    {
        return $this->formFieldName;
    }
}
