<?php

namespace Ffcms\Templex\Helper\Html\Form\Button;

use League\Plates\Engine;

/**
 * Class Submit. Render submit button
 * @package Ffcms\Templex\Helper\Html\Form\Button
 */
class Submit implements ButtonInterface
{
    private $engine;

    /**
     * Submit constructor.
     * @param Engine $engine
     */
    public function __construct(Engine $engine)
    {
        $this->engine = $engine;
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

        $text = htmlentities($text, ENT_QUOTES, 'UTF-8');

        return $this->engine->render('form/button/submit', [
            'text' => $text,
            'properties' => $properties
        ]);
    }
}
