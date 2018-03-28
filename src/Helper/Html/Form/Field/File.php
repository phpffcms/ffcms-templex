<?php

namespace Ffcms\Templex\Helper\Html\Form\Field;


use Ffcms\Templex\Helper\Html\Dom;

/**
 * Class File. Build file field html
 * @package Ffcms\Templex\Helper\Html\Form\Field
 */
class File extends StandardField
{

    /**
     * Build output html
     * @param array|null $properties
     * @return null|string
     */
    public function html(?array $properties = null): ?string
    {
        $properties['type'] = 'file';
        $properties['name'] = $this->getUniqueFieldName();

        if (!isset($properties['id'])) {
            $properties['id'] = $this->getUniqueFieldId();
        }

        return (new Dom())->input($properties);
    }
}