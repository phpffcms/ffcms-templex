<?php

namespace Ffcms\Templex\Helper\Html\Form;


use Ffcms\Templex\Helper\Html\Form\Button\ButtonInterface;
use League\Plates\Engine;

/**
 * Class Button
 * @package Ffcms\Templex\Helper\Html\Form
 * @method Submit(string $text, ?array $properties = null)
 */
class Button
{
    private $model;
    private $engine;

    private $buttons;

    /**
     * Button constructor.
     * @param ModelInterface $model
     * @param Engine $engine
     */
    public function __construct(ModelInterface $model, Engine $engine)
    {
        $this->model = $model;
        $this->engine = $engine;
    }

    /**
     * Make buttons magic callback
     * @param string $type
     * @param array|null $arguments
     */
    public function __call(string $type, ?array $arguments = null): void
    {
        if (!$arguments || !isset($arguments[0]) || !is_string($arguments[0])) {
            return;
        }

        $callback = 'Ffcms\Templex\Helper\Html\Form\Button\\' . ucfirst($type);
        if (!class_exists($callback)) {
            return;
        }
        /** @var ButtonInterface $class */
        $class = new $callback($this->engine);
        $this->buttons[] = $class->html($arguments[0], $arguments[1]);
    }

    /**
     * Get all buttons
     * @return array|null
     */
    public function buttons(): ?array
    {
        return $this->buttons;
    }
}