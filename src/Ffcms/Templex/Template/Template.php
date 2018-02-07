<?php

namespace Ffcms\Templex\Template;

use Ffcms\Templex\Helper\Html\Table;
use Ffcms\Templex\Helper\Html\Listing;
use Ffcms\Templex\Helper\Html\Pagination;

/**
 * Class Template. Extend default template core
 * @package Ffcms\Templex\Template
 * @method Table table(?array $properties = null)
 * @method Listing listing(string $type, ?array $properties)
 * @method Pagination pagination(array $url, ?array $properties = null, ?array $linkProperties = null)
 */
class Template extends \League\Plates\Template\Template
{
    // @todo: implement some core-native features
}