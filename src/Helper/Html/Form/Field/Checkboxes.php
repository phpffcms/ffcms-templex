<?php

namespace Ffcms\Templex\Helper\Html\Form\Field;


use Ffcms\Templex\Exceptions\Error;
use Ffcms\Templex\Helper\Html\Dom;

/**
 * Class Checkboxes. Build checkboxes html
 * @package Ffcms\Templex\Helper\Html\Form\Field
 */
class Checkboxes extends StandardField
{

    /**
     * Build output html
     * @param array|null $properties
     * @return null|string
     */
    public function html(?array $properties = null): ?string
    {
        $options = $properties['options'];
        $properties['type'] = 'checkbox';
        if (!is_array($options)) { // check if options is passed
            Error::add('Form field error: checkboxes options is emtpy for field: ' . $this->fieldName, __FILE__);
            return null;
        }
        $useKey = (bool)$properties['optionsKey'];
        unset($properties['options'], $properties['optionsKey'], $properties['value'], $properties['id']);

        if (!isset($properties['name'])) {
            $properties['name'] = $this->fieldNameWithForm;
        }

        $properties['name'] .= '[]';

        $html = null;
        foreach ($options as $idx => $option) {
            $properties['value'] = ($useKey ? $idx : $option);

            if (is_array($this->value) && in_array($properties['value'], $this->value)) {
                $properties['checked'] = null;
            } else {
                unset($properties['checked']);
            }
            $properties['id'] = $this->fieldNameWithForm . '-' . $idx;
            $arrayProperties = $properties['arrayLabelProperties'] ?? null;
            $arrayProperties['for'] = $this->fieldNameWithForm . '-' . $idx;

            $html .= (new Dom())->input($properties); // input type=checkbox
            $html .= (new Dom())->label(function () use ($option){
                return htmlentities($option, null, 'UTF-8');
            }, $arrayProperties);
            $html .= PHP_EOL;
        }

        return $html;
    }

    /**
     * Get label input as array
     * @param array|null $properties
     * @return array|null
     */
    public function asArray(?array $properties = null): ?array
    {
        $html = $this->html($properties);
        return explode(PHP_EOL, $html);
    }
}