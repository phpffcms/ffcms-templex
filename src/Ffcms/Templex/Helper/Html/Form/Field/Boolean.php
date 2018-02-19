<?php

namespace Ffcms\Templex\Helper\Html\Form\Field;

use Ffcms\Templex\Helper\Html\Dom;

/**
 * Class Checkbox.
 * @package Ffcms\Templex\Helper\Html\Form\Field
 */
class Boolean extends StandardField
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
        $properties['type'] = 'checkbox';
        if (!isset($properties['id'])) {
            $properties['id'] = $this->fieldNameWithForm;
        }

        // build fake checkbox with value=0 and hidden type
        $disabled = (new Dom())->input(function () {
        }, [
            'name' => $properties['name'],
            'value' => 0,
            'type' => 'hidden'
        ]);

        // set value = 1 for displayed checkbox and status "checked" if value equals
        $properties['value'] = 1;
        if ((int)$this->value === 1 || (bool)$this->value === true) {
            $properties['checked'] = true;
        }

        // render output html from template
        return $this->engine->render('form/field/boolean', [
            'properties' => $properties,
            'label' => $this->model->getLabel($this->fieldName),
            'helper' => $helper,
            'hidden' => $disabled
        ]);
    }
}
