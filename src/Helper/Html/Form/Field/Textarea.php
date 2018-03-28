<?php

namespace Ffcms\Templex\Helper\Html\Form\Field;


use Ffcms\Templex\Helper\Html\Dom;

class Textarea extends StandardField
{

    /**
     * Build output html
     * @param array|null $properties
     * @return null|string
     */
    public function html(?array $properties = null): ?string
    {
        // set global name name="fieldName"
        $properties['name'] = $this->getUniqueFieldName();
        if (!isset($properties['id'])) {
            $properties['id'] = $this->getUniqueFieldId();
        }

        return (new Dom())->textarea(function() {
            return htmlentities($this->value, ENT_QUOTES, 'UTF-8');
        }, $properties);
    }
}