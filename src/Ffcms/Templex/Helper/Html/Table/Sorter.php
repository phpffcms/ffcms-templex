<?php

namespace Ffcms\Templex\Helper\Html\Table;

use Ffcms\Templex\Helper\Html\Dom;
use Ffcms\Templex\Helper\Html\Table;

/**
 * Class Sorter. Sorter features for tables.
 * @package Ffcms\Templex\Helper\Html\Table
 */
class Sorter implements RenderElement
{
    const SORT_ASC = 1;
    const SORT_DESC = 2;

    /** @var array */
    private $columns;
    private $url;

    /**
     * Sorter constructor.
     * @param array $columns
     */
    public function __construct(array $columns, ?string $url = null)
    {
        $this->columns = $columns;
        $this->url = $url;
        // if url not passed by - try to get from PHP
        if (!$this->url) {
            $this->url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://" . $_SERVER[HTTP_HOST] . strtok($_SERVER[REQUEST_URI], '?');
        }
    }

    /**
     * Get sorters html code for column index
     * @param int $order
     * @return null|string
     */
    public function getColumnSorters(int $order): ?string
    {
        if (!isset($this->columns[$order])) {
            return null;
        }

        // get query string name and current value
        $queryString = $this->columns[$order];
        $queryValue = 0;
        if (isset($_GET[$queryString]) && in_array((int)$_GET[$queryString], [1, 2], true)) {
            $queryValue = (int)$_GET[$queryString];
        }

        $ascLink = '';
        $descLink = '';
        // build asc link
        if ($queryValue === SORT_ASC) {
            $ascLink = "&uarr;";
        } else {
            $ascLink = (new Dom())->a(function () {
                return "&uarr;";
            }, ['href' => $this->url . '?' . http_build_query(array_merge($_GET, [$queryString => static::SORT_ASC]))]);
        }

        // build desc link
        if ($queryValue === SORT_DESC) {
            $descLink = "&darr;";
        } else {
            $descLink = (new Dom())->a(function () {
                return "&darr;";
            }, ['href' => $this->url . '?' . http_build_query(array_merge($_GET, [$queryString => static::SORT_DESC]))]);
        }

        return $ascLink . ' ' . $descLink;
    }

    public function html(): ?string
    {
        return '';
    }
}
