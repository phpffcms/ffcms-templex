<?php

namespace Ffcms\Templex\Helper\Html\Form\Field;

use Ffcms\Templex\Exceptions\Error;
use Ffcms\Templex\Helper\Html\Dom;

/**
 * Class Radio. Build radio buttons
 * @package Helper\Html\Form\Field
 */
class Radio extends StandardField
{
    /**
     * Build output html
     * @param array|null $properties
     * @return null|string
     */
    public function html(?array $properties = null): ?string
    {
        if (!$properties['options'] || !is_array($properties['options'])) {
            Error::add('Form field error: radio button options is emtpy for field: ' . $this->fieldName, __FILE__);
            return null;
        }

        $properties['name'] = $this->getUniqueFieldName();
        $properties['type'] = 'radio';
        if (!isset($properties['id'])) {
            $properties['id'] = $this->getUniqueFieldId();
        }

        $options = $properties['options'];
        $useKey = (bool)$properties['optionsKey'];
        unset($properties['options'], $properties['value'], $properties['id']);

        $html = '';
        foreach ($options as $idx => $option) {
            $properties['value'] = ($useKey ? $idx : $option);

            if ($this->value != null && $properties['value'] === $this->value) {
                $properties['checked'] = null;
            } else {
                unset($properties['checked']);
            }

            $properties['id'] = $this->getUniqueFieldId() . '-' . $idx;
            $arrayProperties = $properties['arrayLabelProperties'] ?? null;
            $arrayProperties['for'] = $this->getUniqueFieldId() . '-' . $idx;

            $html .= (new Dom())->input($properties); // input type=checkbox
            $html .= (new Dom())->label(function () use ($option) {
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
