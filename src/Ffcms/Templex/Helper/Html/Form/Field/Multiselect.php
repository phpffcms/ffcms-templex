<?php

namespace Ffcms\Templex\Helper\Html\Form\Field;


use Ffcms\Templex\Exceptions\Error;
use Ffcms\Templex\Helper\Html\Dom;

/**
 * Class Multiselect
 * @package Ffcms\Templex\Helper\Html\Form\Field
 */
class Multiselect extends StandardField
{

    /**
     * Build output html
     * @param array|null $properties
     * @return null|string
     */
    public function html(?array $properties = null): ?string
    {
        // check if options is passed
        $options = $properties['options'];
        if (!is_array($options)) {
            Error::add('Form field error: multiselect should not have no options: ' . $this->fieldName, __FILE__);
            return null;
        }
        unset($properties['options']);

        // define "multiple" property
        $properties['multiple'] = null;
        // check if key-ordering used
        $keyOrder = (bool)$properties['optionsKey'];
        unset($properties['optionsKey']);

        // define name and id
        $properties['name'] = $this->fieldNameWithForm . '[]';
        if (!isset($properties['id'])) {
            $properties['id'] = $this->fieldNameWithForm;
        }

        // render output html code
        return (new Dom())->select(function() use ($options, $keyOrder) {
            $opthtml = null;
            foreach ($options as $key => $val) {
                $optpr = [];
                $optpr['value'] = ($keyOrder ? $key : $val);
                if (in_array($optpr['value'], $this->value)) {
                    $optpr['selected'] = null;
                }

                $opthtml .= (new Dom())->option(function() use ($val) {
                    return htmlentities($val, null, 'UTF-8');
                }, $optpr);
            }

            return $opthtml;
        }, $properties);
    }
}