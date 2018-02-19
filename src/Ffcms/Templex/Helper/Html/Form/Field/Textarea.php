<?php

namespace Ffcms\Templex\Helper\Html\Form\Field;

/**
 * Class Textarea. Textarea field implementation
 * @package Ffcms\Templex\Helper\Html\Form\Field
 */
class Textarea extends StandardField
{

    /**
     * Build output html
     * @param array|null $properties
     * @param string|null $helper
     * @return null|string
     */
    public function html(?array $properties = null, ?string $helper = null): ?string
    {
        $properties['name'] = $this->fieldNameWithForm;
        if (!isset($properties['id'])) {
            $properties['id'] = $this->fieldNameWithForm;
        }

        return $this->engine->render('form/field/textarea', [
            'properties' => $properties,
            'label' => $this->model->getLabel($this->fieldName),
            'helper' => $helper,
            'value' => htmlentities($this->value, null, 'UTF-8')
        ]);
    }
}
