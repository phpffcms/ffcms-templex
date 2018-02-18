<?php

namespace Ffcms\Templex\Helper\Html\Form\Field;


/**
 * Class Checkboxes. Multiple checkboxes implementation
 * @package Ffcms\Templex\Helper\Html\Form\Field
 */
class Checkboxes extends StandardField
{

    /**
     * Build output html
     * @param array|null $properties
     * @param string|null $helper
     * @return null|string
     */
    public function html(?array $properties = null, ?string $helper = null): ?string
    {
        $options = $properties['options'];
        $properties['type'] = 'checkbox';
        if (!is_iterable($options)) { // check if options is passed
            return null;
        }
        $useKey = (bool)$properties['optionsKey'];
        unset($properties['options'], $properties['optionsKey'], $properties['value'], $properties['id']);

        if (!isset($properties['name'])) {
            $properties['name'] = $this->fieldNameWithForm;
        }

        $properties['name'] .= '[]';

        return $this->engine->render('form/field/checkboxes', [
            'value' => $this->value,
            'properties' => $properties,
            'usekey' => $useKey,
            'options' => $options,
            'label' => $this->model->getLabel($this->fieldName),
            'helper' => $helper,
            'fieldname' => $this->fieldNameWithForm,
        ]);
    }
}