<?php

namespace Ffcms\Templex\Helper\Html\Form\Fieldset;

use Ffcms\Templex\Helper\Html\Form\Field\Checkboxes as CheckboxesField;

/**
 * Class Checkboxes. Multiple checkboxes implementation
 * @package Ffcms\Templex\Helper\Html\Form\Field
 */
class Checkboxes extends StandardFieldset
{
    private $field;

    /**
     * Init dependency injection on field
     */
    public function before()
    {
        $this->field = new CheckboxesField($this->model, $this->fieldName);
    }

    /**
     * Build output html
     * @param array|null $properties
     * @param string|null $helper
     * @return null|string
     */
    public function html(?array $properties = null, ?string $helper = null): ?string
    {
        $labelProperties = $properties['labelProperties'] ?? null;
        return $this->engine->render('_core/form/fieldset/checkboxes', [
            'properties' => $properties,
            'label' => $this->model->getLabel($this->fieldName),
            'helper' => $helper,
            'field' => $this->field,
            'labelProperties' => $labelProperties
        ]);
    }
}
