<?php

namespace Ffcms\Templex\Helper\Html;


use Ffcms\Templex\Helper\Html\Form\Button;
use Ffcms\Templex\Helper\Html\Form\Button\Submit;
use Ffcms\Templex\Helper\Html\Form\Field;
use Ffcms\Templex\Helper\Html\Form\ModelInterface;
use League\Plates\Engine;
use League\Plates\Extension\ExtensionInterface;

/**
 * Class Form. Form helper
 * @package Ffcms\Templex\Helper\Html
 */
class Form implements ExtensionInterface
{
    /** @var Engine */
    public static $engine;

    /** @var ModelInterface */
    private $model;
    private $properties;

    /** @var Field */
    private $field;
    /** @var Button */
    private $button;

    /**
     * Build instance with model and form properties
     * @param ModelInterface $model
     * @param array|null $properties
     * @return Form
     */
    public static function factory(ModelInterface $model, ?array $properties = null): Form
    {
        $engine = self::$engine;

        $instance = new self();
        $instance->model = $model;
        $instance->properties = $properties;
        $instance->field = new Field($model, $engine);
        $instance->button = new Button($model, $engine);
        $instance::$engine = $engine;

        return $instance;
    }

    /**
     * Register plate extension
     * @param Engine $engine
     */
    public function register(Engine $engine)
    {
        self::$engine = $engine;
        $engine->registerFunction('form', [$this, 'factory']);
    }

    /**
     * Start form - display open tag
     * @param bool $csrf
     * @return null|string
     */
    public function start(bool $csrf = true): ?string
    {
        // check if form name is defined
        if (!$this->properties['name']) {
            $this->properties['name'] = $this->model->getFormName();
        }
        $this->properties['id'] = $this->properties['name'];

        // check if submit method is defined
        if (!$this->properties['method']) {
            $this->properties['method'] = 'POST';
        }

        return '<form' . Dom::applyProperties($this->properties) . '>';
    }

    /**
     * Form stop - closing tag & javascript features
     * @return string
     */
    public function stop(): string
    {
        return '</form>';
    }

    /**
     * Read-only access to 'field' property
     * @return Field
     */
    public function field(): Field
    {
        return $this->field;
    }

    /**
     * Read-only access to button instance
     * @return Button
     */
    public function button(): Button
    {
        return $this->button;
    }

}