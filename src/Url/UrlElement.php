<?php

namespace Ffcms\Templex\Url;


/**
 * Class UrlElement.
 * @package Ffcms\Templex\Url
 */
class UrlElement
{
    private $input;

    private $controllerAction;
    private $params;
    private $query;

    /**
     * UrlElement constructor.
     * @param array|null $input
     */
    public function __construct(?array $input = null)
    {
        $this->input = $input;
        if (isset($input[0]) && is_string($input[0])) {
            $this->controllerAction = $input[0];
        }

        if (isset($input[1]) && is_array($input[1])) {
            $this->params = $input[1];
        }

        if (isset($input[2]) && is_array($input[2])) {
            $this->query = $input[2];
        }
    }

    /**
     * Url factory
     * @param array|null $input
     * @return self
     */
    public static function factory(?array $input = null): self
    {
        return new self($input);
    }

    /**
     * Get controller/action string
     * @return string|null
     */
    public function getControllerAction(): ?string
    {
        return $this->controllerAction;
    }

    /**
     * Get action params, 2nd element
     * @return array|null
     */
    public function getParams(): ?array
    {
        return $this->params;
    }

    /**
     * Get query params (3rd element)
     * @return array|null
     */
    public function getQuery(): ?array
    {
        return $this->query;
    }

    /**
     * Check if controller/action value is valid
     * @return bool
     */
    public function isValidControllerAction(): bool
    {
        return $this->controllerAction && strpos($this->controllerAction, '/') !== false;
    }

}