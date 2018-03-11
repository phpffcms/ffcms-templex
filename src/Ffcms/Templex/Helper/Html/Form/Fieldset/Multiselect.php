<?php

namespace Ffcms\Templex\Helper\Html\Form\Fieldset;

use Ffcms\Templex\Exceptions\Error;
use Ffcms\Templex\Helper\Html\Form\Field\Multiselect as MultiselectField;

/**
 * Class Multiselect. Select * options with multiple array features
 * @package Ffcms\Templex\Helper\Html\Form\Field
 */
class Multiselect extends StandardFieldset
{
    private $field;

    /**
     * Init multiselect field dependency
     */
    public function before()
    {
        $this->field = new MultiselectField($this->model, $this->fieldName);
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
        return $this->engine->render('form/fieldset/multiselect', [
            'properties' => $properties,
            'label' => $this->model->getLabel($this->fieldName),
            'helper' => $helper,
            'field' => $this->field,
            'labelProperties' => $labelProperties
        ]);
    }
}
