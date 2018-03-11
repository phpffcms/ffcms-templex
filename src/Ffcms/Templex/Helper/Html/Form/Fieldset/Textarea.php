<?php

namespace Ffcms\Templex\Helper\Html\Form\Fieldset;

use Ffcms\Templex\Helper\Html\Form\Field\Textarea as TextareaField;

/**
 * Class Textarea. Textarea field implementation
 * @package Ffcms\Templex\Helper\Html\Form\Field
 */
class Textarea extends StandardFieldset
{
    private $field;

    /**
     * Initialize native field
     */
    public function before()
    {
        $this->field = new TextareaField($this->model, $this->fieldName);
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
        return $this->engine->render('form/fieldset/textarea', [
            'properties' => $properties,
            'label' => $this->model->getLabel($this->fieldName),
            'helper' => $helper,
            'field' => $this->field,
            'labelProperties' => $labelProperties
        ]);
    }
}
