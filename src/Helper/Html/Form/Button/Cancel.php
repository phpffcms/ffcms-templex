<?php

namespace Ffcms\Templex\Helper\Html\Form\Button;


use Ffcms\Templex\Helper\Html\Form\ModelInterface;
use League\Plates\Engine;

/**
 * Class Cancel. Render cancel button
 * @package Ffcms\Templex\Helper\Html\Form\Button
 */
class Cancel implements ButtonInterface
{
    private $engine;
    private $model;

    /**
     * ButtonInterface constructor.
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
     * @return null|string
     */
    public function html(string $text, ?array $properties = null): ?string
    {
        $text = htmlentities($text, ENT_QUOTES, 'UTF-8');
        $link = $properties['link'];
        unset($properties['link']);

        if (!$link || !is_array($link)) {
            return null;
        }

        return $this->engine->render('_core/form/button/cancel', [
            'text' => $text,
            'link' => $link,
            'properties' => $properties
        ]);
    }
}