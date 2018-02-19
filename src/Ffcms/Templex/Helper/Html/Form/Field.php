<?php

namespace Ffcms\Templex\Helper\Html\Form;

use Ffcms\Templex\Exceptions\Error;
use League\Plates\Engine;
use Ffcms\Templex\Helper\Html\Form\Field\FieldInterface;

/**
 * Class Field. Make html code of form fields.
 * @package Ffcms\Templex\Helper\Html\Form
 * @method text(string $name, ?array $properties = null, ?string $helper = null)
 * @method textarea(string $name, ?array $properties = null, ?string $helper = null)
 * @method select(string $name, ?array $properties = null, ?string $helper = null)
 * @method password(string $name, ?array $properties = null, ?string $helper = null)
 * @method multiselect(string $name, ?array $properties = null, ?string $helper = null)
 * @method hidden(string $name, ?array $properties = null)
 * @method file(string $name, ?array $properties = null, ?string $helper = null)
 * @method boolean(string $name, ?array $properties = null, ?string $helper = null)
 * @method checkboxes(string $name, ?array $properties = null, ?string $helper = null)
 */
class Field
{
    /** @var ModelInterface */
    private $model;

    /** @var Engine */
    private $engine;

    private $used;

    /**
     * Field constructor.
     * @param ModelInterface $model
     * @param Engine $engine
     */
    public function __construct(ModelInterface $model, Engine $engine)
    {
        $this->model = $model;
        $this->engine = $engine;
    }

    /**
     * Some magic inside :)
     * @param string $type
     * @param array|null $arguments
     * @return string|null
     */
    public function __call(string $type, ?array $arguments = null): ?string
    {
        // arguments[0] = model field name
        if (!$arguments || !isset($arguments[0]) || !is_string($arguments[0])) {
            return null;
        }

        // get field name
        $attr = (string)$arguments[0];

        // initialize worker for field type
        $callback = 'Ffcms\Templex\Helper\Html\Form\Field\\' . ucfirst($type);
        if (!class_exists($callback) || isset($this->used[$attr])) {
            Error::add('Form field error: no type exist or field is alway used: ' . $attr . '[' . $type . ']', __FILE__);
            return null;
        }
        // mark as used
        $this->used[$attr] = true;

        /** @var FieldInterface $field */
        $field = new $callback($this->model, $attr, $this->engine);
        return $field->html($arguments[1], $arguments[2]);
    }

    /**
     * Manual any-way field made by your hands like $form->field()->manual(function(){return 'hello world';});
     * @param \Closure $callback
     * @return string|null
     */
    public function manual(\Closure $callback): ?string
    {
        return $callback();
    }
}
