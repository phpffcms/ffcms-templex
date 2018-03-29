<?php

namespace Ffcms\Templex\Helper\Html;

use Ffcms\Templex\Helper\Html\Form\Button;
use Ffcms\Templex\Helper\Html\Form\Fieldset;
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
    /** @var Fieldset */
    private $fieldset;
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
        $instance->field = new Field($model);
        $instance->fieldset = new Fieldset($model, $engine, $instance->field);
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
        // render form template
        return static::$engine->render('form/start', [
            'properties' => $this->properties,
            'csrfField' => ($csrf ? $this->field()->hidden('_csrf_token', ['value' => $this->model->_csrf_token]) : null),
        ]);
    }

    /**
     * Form stop - closing tag & javascript features
     * @param bool $validator
     * @return string
     */
    public function stop($validator = true): string
    {
        return static::$engine->render('form/stop', [
            'validator' => $validator,
            'model' => $this->model
        ]);
    }

    /**
     * Get field class instance
     * @return Field
     */
    public function field(): Field
    {
        return $this->field;
    }

    /**
     * Get fieldset class instance
     * @return Fieldset
     */
    public function fieldset(): Fieldset
    {
        return $this->fieldset;
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
