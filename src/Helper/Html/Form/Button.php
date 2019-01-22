<?php

namespace Ffcms\Templex\Helper\Html\Form;

use Ffcms\Templex\Exceptions\Error;
use Ffcms\Templex\Helper\Html\Form\Button\ButtonInterface;
use League\Plates\Engine;

/**
 * Class Button
 * @package Ffcms\Templex\Helper\Html\Form
 * @method submit(string $text, ?array $properties = null)
 * @method cancel(string $text, ?array $properties = null)
 */
class Button
{
    private $model;
    private $engine;

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
     * @return string|null
     */
    public function __call(string $type, ?array $arguments = null): ?string
    {
        if (!$arguments || !isset($arguments[0]) || !is_string($arguments[0])) {
            return null;
        }

        $callback = 'Ffcms\Templex\Helper\Html\Form\Button\\' . ucfirst($type);
        if (!class_exists($callback)) {
            Error::add('Form button error: type ' . $type . ' not exist', __FILE__);
            return null;
        }
        /** @var ButtonInterface $class */
        $class = new $callback($this->engine, $this->model);
        return $class->html($arguments[0], ($arguments[1] ?? null));
    }
}
