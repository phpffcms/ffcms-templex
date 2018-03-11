<?php

namespace Ffcms\Templex\Helper\Html\Form\Fieldset;

use Ffcms\Templex\Helper\Html\Form\Field\Select as SelectField;

class Select extends StandardFieldset
{
    /** @var SelectField */
    private $field;

    /**
     * Build field dependency
     */
    public function before()
    {
        $this->field = new SelectField($this->model, $this->fieldName);
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
        return $this->engine->render('form/fieldset/select', [
            'properties' => $properties,
            'label' => $this->model->getLabel($this->fieldName),
            'helper' => $helper,
            'field' => $this->field,
            'labelProperties' => $labelProperties
        ]);
    }
}
