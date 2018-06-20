<?php

namespace Ffcms\Templex\Helper\Html\Form;

use Ffcms\Templex\Exceptions\Error;
use Ffcms\Templex\Helper\Html\Form\Field\FieldInterface;

/**
 * Class Field. Build form fields
 * @package Ffcms\Templex\Helper\Html\Form
 * @method text(string $name, ?array $properties = null)
 * @method textarea(string $name, ?array $properties = null)
 * @method select(string $name, ?array $properties = null)
 * @method password(string $name, ?array $properties = null)
 * @method multiselect(string $name, ?array $properties = null)
 * @method hidden(string $name, ?array $properties = null)
 * @method file(string $name, ?array $properties = null)
 * @method boolean(string $name, ?array $properties = null)
 * @method checkboxes(string $name, ?array $properties = null)
 * @method radio(string $name, ?array $properties = null)
 */
class Field
{
    /** @var ModelInterface */
    protected $model;

    /** @var array */
    private $used = [];

    /**
     * Field constructor. Pass model inside
     * @param ModelInterface $model
     */
    public function __construct(ModelInterface $model)
    {
        $this->model = $model;
    }

    /**
     * Process call to dynamic method names, like ->text('field', [properties])
     * @param string $name
     * @param array|null $arguments
     * @return null|string
     */
    public function __call(string $name, ?array $arguments = null)
    {
        // arguments[0] = model field name
        if (!$arguments || !isset($arguments[0]) || !is_string($arguments[0])) {
            return null;
        }

        // get field name
        $attr = (string)$arguments[0];

        // initialize worker for field type
        $callback = 'Ffcms\Templex\Helper\Html\Form\Field\\' . ucfirst($name);
        if (!class_exists($callback) || isset($this->used[$attr])) {
            Error::add('Form field error: no type exist or field is alway used: ' . $attr . '[' . $name . ']', __FILE__);
            return null;
        }

        // mark as used
        $this->used[$attr] = true;

        /** @var FieldInterface $field */
        $field = new $callback($this->model, $attr);
        return $field->html($arguments[1]);
    }
}
