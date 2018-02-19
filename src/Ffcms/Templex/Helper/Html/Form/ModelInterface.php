<?php

namespace Ffcms\Templex\Helper\Html\Form;

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
}
