<?php

namespace Ffcms\Templex\Helper\Html\Form;


/**
 * Class Model. Abstract model for form building
 * @package Ffcms\Templex\Helper\Html\Form
 */
abstract class Model implements ModelInterface
{
    public $_csrf_token;
    public $_name;

    public function __construct()
    {
        $cname = get_class($this);
        $this->_name = substr($cname, strrpos($cname, '\\'));
    }

    /**
     * Get model field label by attr name
     * @param string $name
     * @return null|string
     */
    public function getLabel(string $name): ?string
    {
        $labels = $this->labels();
        $text = null;

        // check if dot notation used for array items
        if (strpos('.', $name)) {
            if (!isset($labels[$name])) {
                $text = (string)$labels[strtok($name, '.')];
            } else {
                $text = (string)$labels[$name];
            }
        } else {
            $text = (string)$labels[$name];
        }

        // if text is still null or empty - set same with label name
        return $text ?? $name;
    }

    /**
     * Get form name
     * @return string
     */
    public function getFormName(): string
    {
        return $this->_name;
    }
}