<?php

namespace Ffcms\Templex\Helper\Html\Form\Fieldset;

use Ffcms\Templex\Helper\Html\Form\Field\File as FileField;


/**
 * Class File. Input type=file implementation
 * @package Ffcms\Templex\Helper\Html\Form\Field
 */
class File extends StandardFieldset
{
    /** @var FileField */
    private $field;

    /**
     * Make dependency injection on file field
     */
    public function before()
    {
        $this->field = new FileField($this->model, $this->fieldName);
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
        return $this->engine->render('form/fieldset/file', [
            'properties' => $properties,
            'label' => $this->model->getLabel($this->fieldName),
            'helper' => $helper,
            'field' => $this->field,
            'labelProperties' => $labelProperties
        ]);
    }
}
