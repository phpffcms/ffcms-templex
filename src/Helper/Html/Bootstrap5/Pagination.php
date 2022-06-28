<?php

namespace Ffcms\Templex\Helper\Html\Bootstrap5;

use Ffcms\Templex\Helper\Html\Dom;
use \Ffcms\Templex\Helper\Html\Pagination as NativePagination;

/**
 * Class Pagination. Bootstrap5 pagination helper
 * @package Ffcms\Templex\Helper\Html\Bootstrap5
 */
class Pagination extends NativePagination
{

    /**
     * Define bootstrap features
     * @param array $url
     * @param array|null $properties
     * @param array|null $liProperties
     * @param array|null $aProperties
     * @return self
     */
    public static function factory(array $url, ?array $properties = null, ?array $liProperties = null, ?array $aProperties = null)
    {
        // bootstrap features
        if (!isset($properties['class'])) {
            $properties['class'] = 'pagination';
        }

        if (!isset($liProperties['class'])) {
            $liProperties['class'] = 'page-item';
        }

        if (!isset($aProperties['class'])) {
            $aProperties['class'] = 'page-link';
        }

        $instance = new self();
        $instance->url = $url;
        $instance->properties = $properties;
        $instance->liProperties = $liProperties;
        $instance->aProperties = $aProperties;

        return $instance;
    }

    /**
     * Override display function - add bootstrap class & other features
     * @return null|string
     */
    public function display(): ?string
    {
        $html = parent::display();
        return (new Dom())->nav(function () use ($html) {
            return $html;
        }, ['aria-label' => 'pagination']);
    }
}
