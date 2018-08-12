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

    protected $_badAttr;

    /**
     * Model constructor.
     */
    public function __construct()
    {
        $cname = get_class($this);
        if (!$this->_name) {
            $this->_name = substr($cname, strrpos($cname, '\\')+1);
        }
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
        if (strpos($name, '.')) {
            if (!isset($labels[$name])) {
                $text = (string)$labels[strtok($name, '.')];
            } else {
                $text = (string)$labels[$name];
            }
        } else {
            $text = (string)$labels[$name];
        }

        // if text is still null or empty - display attribute variable name
        return (!$text || strlen($text) < 1 ? ucfirst(mb_strtolower($name)) : $text);
    }

    /**
     * Get form name
     * @return string
     */
    public function getFormName(): string
    {
        return $this->_name;
    }

    /**
     * Get fail validated attribute names
     * @return array|null
     */
    public function getBadAttributes(): ?array
    {
        return $this->_badAttr;
    }
}
