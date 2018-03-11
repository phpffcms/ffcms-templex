<?php

namespace Ffcms\Templex\Helper\Html\Form\Fieldset;

use Ffcms\Templex\Helper\Html\Form\Field\Text as TextField;

/**
 * Class Text. Text input field implementation
 * @package Ffcms\Templex\Helper\Form\Field
 */
class Text extends StandardFieldset
{
    /** @var TextField */
    private $field;

    /**
     * Initialize field dependency injection
     */
    protected function before()
    {
        $this->field = new TextField($this->model, $this->fieldName);
    }

    /**
     * Render output html
     * @param array|null $properties
     * @param string|null $helper
     * @return null|string
     */
    public function html(?array $properties = null, ?string $helper = null): ?string
    {
        $labelProperties = $properties['labelProperties'] ?? null;
        return $this->engine->render('form/fieldset/text', [
            'properties' => $properties,
            'label' => $this->model->getLabel($this->fieldName),
            'helper' => $helper,
            'field' => $this->field,
            'labelProperties' => $labelProperties
        ]);
    }
}
