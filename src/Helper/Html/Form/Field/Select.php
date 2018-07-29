<?php

namespace Ffcms\Templex\Helper\Html\Form\Field;

use Ffcms\Templex\Helper\Html\Dom;

/**
 * Class Select. Build <select></select> field with options array
 * @package Ffcms\Templex\Helper\Html\Form\Field
 */
class Select extends StandardField
{

    /**
     * Build output html
     * @param array|null $properties
     * @return null|string
     */
    public function html(?array $properties = null): ?string
    {
        // check if options is defined
        $options = $properties['options'];
        if (!is_array($options)) {
            return null;
        }
        unset($properties['options']);

        // check if key-ordering used
        $keyOrder = (bool)$properties['optionsKey'];
        unset($properties['optionsKey']);

        // set name & ids
        $properties['name'] = $this->getUniqueFieldName();
        if (!isset($properties['id'])) {
            $properties['id'] = $this->getUniqueFieldId();
        }

        return (new Dom())->select(function () use ($options, $keyOrder) {
            $opthtml = null;
            foreach ($options as $key => $val) {
                $optpr = [];
                $optpr['value'] = ($keyOrder ? $key : $val);
                if ((string)$optpr['value'] === (string)$this->value && (string)$this->value !== '') {
                    $optpr['selected'] = null;
                }

                $opthtml .= (new Dom())->option(function () use ($val) {
                    return htmlentities($val, null, 'UTF-8');
                }, $optpr);
            }

            return $opthtml;
        }, $properties);
    }
}
