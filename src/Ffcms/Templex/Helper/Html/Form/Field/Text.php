<?php

namespace Ffcms\Templex\Helper\Html\Form\Field;


/**
 * Class Text. Text input field implementation
 * @package Ffcms\Templex\Helper\Form\Field
 */
class Text extends StandardField
{
    /**
     * Render output html
     * @param array|null $properties
     * @param string|null $helper
     * @return null|string
     */
    public function html(?array $properties = null, ?string $helper = null): ?string
    {
        $properties['type'] = 'text';
        $properties['name'] = $this->fieldNameWithForm;
        if ($this->value) {
            $properties['value'] = htmlentities($this->value, ENT_QUOTES, 'UTF-8');
        }

        if (!isset($properties['id'])) {
            $properties['id'] = $this->fieldNameWithForm;
        }

        return $this->engine->render('form/field/text', [
            'properties' => $properties,
            'label' => $this->model->getLabel($this->fieldName),
            'helper' => $helper
        ]);
    }
}