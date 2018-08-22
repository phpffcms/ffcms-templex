<?php

namespace Ffcms\Templex\Helper\Html\Form\Field;

use Ffcms\Templex\Exceptions\Error;
use Ffcms\Templex\Helper\Html\Dom;

/**
 * Class Hidden. Build input type=hidden element
 * @package Ffcms\Templex\Helper\Html\Form\Field
 */
class Hidden extends StandardField
{

    /**
     * Build output html
     * @param array|null $properties
     * @return null|string
     */
    public function html(?array $properties = null): ?string
    {
        // check if input type=hidden value is defined
        if (!$this->value || (!is_string($this->value) && !is_int($this->value) ) || strlen($this->value) < 1) {
            Error::add('Form field error: hidden field may not have empty value: ' . $this->fieldName, __FILE__);
            return null;
        }

        // set tag attributes
        $properties['type'] = 'hidden';
        $properties['name'] = $this->getUniqueFieldName();
        if (!isset($properties['value'])) {
            $properties['value'] = htmlentities($this->value, ENT_QUOTES, 'UTF-8');
        }

        if (!isset($properties['id'])) {
            $properties['id'] = $this->getUniqueFieldId();
        }

        // render output dom html
        return (new Dom())->input($properties);
    }
}
