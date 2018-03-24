<?php

namespace Ffcms\Templex\Helper\Html\Form\Fieldset;

use Ffcms\Templex\Helper\Html\Form\Field\Password as PasswordField;

/**
 * Class Password
 * @package Ffcms\Templex\Helper\Html\Form\Fieldset
 */
class Password extends StandardFieldset
{
    private $field;

    /**
     * Init password field depednency
     */
    public function before()
    {
        $this->field = new PasswordField($this->model, $this->fieldName);
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
        return $this->engine->render('form/fieldset/password', [
            'properties' => $properties,
            'label' => $this->model->getLabel($this->fieldName),
            'helper' => $helper,
            'field' => $this->field,
            'labelProperties' => $labelProperties
        ]);
    }
}
