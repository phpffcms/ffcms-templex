<?php

namespace Ffcms\Templex\Helper\Html\Form\Field;

class Select extends StandardField
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
        if (!is_iterable($options)) {
            return null;
        }
        unset($properties['options']);

        $keyOrder = (bool)$properties['optionsKey'];
        unset($properties['optionsKey']);

        $properties['name'] = $this->fieldNameWithForm;
        if (!isset($properties['id'])) {
            $properties['id'] = $this->fieldNameWithForm;
        }

        return $this->engine->render('form/field/select', [
            'properties' => $properties,
            'label' => $this->model->getLabel($this->fieldName),
            'helper' => $helper,
            'value' => htmlentities($this->value, null, 'UTF-8'),
            'keys' => $keyOrder,
            'options' => $options
        ]);
    }
}
