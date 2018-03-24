<?php

namespace Ffcms\Templex\Helper\Html\Form\Fieldset;

use Ffcms\Templex\Helper\Html\Dom;
use Ffcms\Templex\Helper\Html\Form\Field\Boolean as BooleanField;

/**
 * Class Checkbox.
 * @package Ffcms\Templex\Helper\Html\Form\Field
 */
class Boolean extends StandardFieldset
{
    private $field;

    /**
     * Initialize field dependency injection
     */
    public function before()
    {
        $this->field = new BooleanField($this->model, $this->fieldName);
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
        // render output html from template
        return $this->engine->render('form/fieldset/boolean', [
            'properties' => $properties,
            'label' => $this->model->getLabel($this->fieldName),
            'helper' => $helper,
            'field' => $this->field,
            'labelProperties' => $labelProperties
        ]);
    }
}
