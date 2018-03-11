<?php

namespace Ffcms\Templex\Helper\Html\Form\Field;

use Ffcms\Templex\Helper\Html\Dom;


/**
 * Class Password
 * @package Ffcms\Templex\Helper\Html\Form\Field
 */
class Password extends StandardField
{

    /**
     * Build output html
     * @param array|null $properties
     * @return null|string
     */
    public function html(?array $properties = null): ?string
    {
        $properties['type'] = 'password';
        $properties['name'] = $this->fieldNameWithForm;

        if (!isset($properties['id'])) {
            $properties['id'] = $this->fieldNameWithForm;
        }

        return (new Dom())->input($properties);
    }
}