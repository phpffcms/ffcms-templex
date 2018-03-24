<?php

namespace Ffcms\Templex\Helper\Html\Form\Field;


use Ffcms\Templex\Helper\Html\Dom;

/**
 * Class Text. Build <input type="text"> field
 * @package Ffcms\Templex\Helper\Html\Form\Field
 */
class Text extends StandardField
{
    /**
     * Build <input> inline container and return html code
     * @param array|null $properties
     * @return null|string
     */
    public function html(?array $properties = null): ?string
    {
        // set type if not defined
        if (!isset($properties['type'])) {
            $properties['type'] = 'text';
        }

        // set global name name="fieldName"
        $properties['name'] = $this->fieldNameWithForm;

        // set value if not defined
        if ($this->value) {
            $properties['value'] = htmlentities($this->value, ENT_QUOTES, 'UTF-8');
        }

        // set id anchor
        if (!isset($properties['id'])) {
            $properties['id'] = $this->fieldNameWithForm;
        }
        // build dom html <input properties value="" />
        return (new Dom())->input($properties);
    }
}