<?php

namespace Ffcms\Templex\Helper\Html\Form\Field;

use Ffcms\Templex\Exceptions\Error;
use Ffcms\Templex\Helper\Html\Dom;

/**
 * Class Hidden. Display input[type=hidden] field inline
 * @package Ffcms\Templex\Helper\Html\Form\Field
 */
class Hidden extends StandardField
{

    /**
     * Build output html
     * @param array|null $properties
     * @param string|null $helper
     * @return null|string
     */
    public function html(?array $properties = null, ?string $helper = null): ?string
    {
        if (!$this->value || !is_string($this->value) || strlen($this->value) < 1) {
            Error::add('Form field error: hidden field may not have empty value: ' . $this->fieldName, __FILE__);
            return null;
        }

        $properties['type'] = 'hidden';
        $properties['name'] = $this->fieldNameWithForm;
        if (!isset($properties['value'])) {
            $properties['value'] = htmlentities($this->value, ENT_QUOTES, 'UTF-8');
        }

        if (!isset($properties['id'])) {
            $properties['id'] = $this->fieldNameWithForm;
        }

        return (new Dom())->input(function () {
            return null;
        }, $properties);
    }
}
