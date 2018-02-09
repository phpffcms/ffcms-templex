<?php

namespace Ffcms\Templex\Helper\Html\Form;

use League\Plates\Engine;
use Ffcms\Templex\Helper\Html\Form\Field\FieldInterface;

/**
 * Class Field. Make html code of form fields.
 * @package Ffcms\Templex\Helper\Html\Form
 * @method text(string $name, ?array $properties = null, ?string $helper = null)
 */
class Field
{
    /** @var ModelInterface */
    private $model;

    /** @var Engine */
    private $engine;

    private $fields = [];

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
     * @return void
     */
    public function __call(string $type, ?array $arguments = null): void
    {
        // arguments[0] = model field name
        if (!$arguments || !isset($arguments[0]) || !is_string($arguments[0])) {
            return;
        }

        // get field name
        $attr = (string)$arguments[0];

        // initialize worker for field type
        $callback = 'Ffcms\Templex\Helper\Html\Form\Field\\' . ucfirst($type);
        if (!class_exists($callback)) {
            return;
        }
        /** @var FieldInterface $field */
        $field = new $callback($this->model, $attr, $this->engine);
        $this->fields[] = $field->html($arguments[1], $arguments[2]);
    }

    /**
     * Manual any-way field made by your hands like $form->field()->manual(function(){return 'hello world';});
     * @param \Closure $callback
     * @return void
     */
    public function manual(\Closure $callback): void
    {
        $this->fields[] = $callback();
    }

    /**
     * Get result fields array
     * @return array
     */
    public function fields()
    {
        return $this->fields;
    }
}
