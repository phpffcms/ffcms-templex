<?php

namespace Ffcms\Templex\Helper\Html\Form;

use Ffcms\Templex\Exceptions\Error;
use League\Plates\Engine;
use Ffcms\Templex\Helper\Html\Form\Fieldset\FieldsetInterface;

/**
 * Class Field. Make html code of form fields.
 * @package Ffcms\Templex\Helper\Html\Form
 * @method text(string $name, ?array $properties = null, ?string $helper = null)
 * @method textarea(string $name, ?array $properties = null, ?string $helper = null)
 * @method select(string $name, ?array $properties = null, ?string $helper = null)
 * @method password(string $name, ?array $properties = null, ?string $helper = null)
 * @method multiselect(string $name, ?array $properties = null, ?string $helper = null)
 * @method file(string $name, ?array $properties = null, ?string $helper = null)
 * @method boolean(string $name, ?array $properties = null, ?string $helper = null)
 * @method checkboxes(string $name, ?array $properties = null, ?string $helper = null)
 * @method radio(string $name, ?array $properties = null, ?string $helper = null)
 */
class Fieldset
{
    /** @var ModelInterface */
    private $model;
    /** @var Engine */
    private $engine;
    /** @var Field */
    private $field;

    private $used;

    /**
     * Field constructor.
     * @param ModelInterface $model
     * @param Engine $engine
     * @param Field $field
     */
    public function __construct(ModelInterface $model, Engine $engine, Field $field)
    {
        $this->model = $model;
        $this->engine = $engine;
        $this->field = $field;
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
        $callback = 'Ffcms\Templex\Helper\Html\Form\Fieldset\\' . ucfirst($type);
        if (!class_exists($callback)) {
            Error::add('Form fieldset error: no callback for field type: ' . $attr . '[' . $type . ']', __FILE__);
            return null;
        }

        /** @var FieldsetInterface $field */
        $field = new $callback($this->model, $attr, $this->engine);
        return $field->html(($arguments[1] ?? null), ($arguments[2] ?? null));
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
