<?php

namespace Ffcms\Templex\Helper\Html\Form\Button;

use Ffcms\Templex\Helper\Html\Form\ModelInterface;
use League\Plates\Engine;

/**
 * Class Submit. Render submit button
 * @package Ffcms\Templex\Helper\Html\Form\Button
 */
class Submit implements ButtonInterface
{
    private $engine;
    private $model;

    /**
     * Submit constructor.
     * @param Engine $engine
     * @param ModelInterface $model
     */
    public function __construct(Engine $engine, ModelInterface $model)
    {
        $this->engine = $engine;
        $this->model = $model;
    }

    /**
     * @param string $text
     * @param array|null $properties
     * @return string|null
     */
    public function html(string $text, ?array $properties = null): ?string
    {
        if (!isset($properties['type'])) {
            $properties['type'] = 'button';
        }

        $properties['name'] = $this->model->getFormName() . '[submit]';
        $text = htmlentities($text, ENT_QUOTES, 'UTF-8');

        return $this->engine->render('_form/button/submit', [
            'text' => $text,
            'properties' => $properties
        ]);
    }
}
