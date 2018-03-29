<?php

namespace Ffcms\Templex\Helper\Html\Form;

/**
 * Interface ModelInterface
 * @package Ffcms\Templex\Helper\Html\Form
 * @property string|null $_csrf_token
 */
interface ModelInterface
{
    /**
     * Form attribute labels
     * @return array
     */
    public function labels(): array;

    /**
     * Get attribute label by name
     * @param string $name
     * @return null|string
     */
    public function getLabel(string $name): ?string;

    /**
     * Get form name
     * @return string
     */
    public function getFormName(): string;

    /**
     * Get failed validation attributes name as array
     * @return array|null
     */
    public function getBadAttributes(): ?array;
}
