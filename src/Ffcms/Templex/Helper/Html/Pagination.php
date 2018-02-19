<?php

namespace Ffcms\Templex\Helper\Html;

use Ffcms\Templex\Exceptions\Error;
use League\Plates\Engine;
use League\Plates\Extension\ExtensionInterface;

/**
 * Class Pagination. Build simple pagination listing.
 * @package Ffcms\Templex\Helper\Html
 */
class Pagination implements ExtensionInterface
{
    private $engine;

    private $url;
    private $properties;
    private $liProperties;
    private $aProperties;

    private $count;
    private $page;
    private $step;
    private $pages;

    /** @var Listing|null */
    private $listing;

    /**
     * Register pagination() function in plates
     * @param Engine $engine
     */
    public function register(Engine $engine)
    {
        $this->engine = $engine;
        $engine->registerFunction('pagination', [$this, 'factory']);
    }

    /**
     * Pagination constructor. Pass pagination params inside
     * @param array $url
     * @param array|null $properties
     * @param array|null $liProperties
     * @param array|null $aProperties
     * @return Pagination
     */
    public static function factory(array $url, ?array $properties = null, ?array $liProperties = null, ?array $aProperties = null): Pagination
    {
        $instance = new self();
        $instance->url = $url;
        $instance->properties = $properties;
        $instance->liProperties = $liProperties;
        $instance->aProperties = $aProperties;

        return $instance;
    }

    /**
     * Define pagination item count, current page number and step size
     * @param int $count
     * @param int $page
     * @param int $step
     * @return Pagination
     */
    public function size(int $count, int $page = 0, int $step = 10): Pagination
    {
        $this->count = $count;
        $this->page = $page;
        $this->step = $step;

        // calculate page count based on elements count & step interval
        $this->pages = ceil($count / $step) - 1;

        // make build
        $this->build();

        return $this;
    }

    /**
     * Build ul*li items
     * @return void
     */
    private function build(): void
    {
        // current page >= total page count or total page count lower then 1
        if ($this->page >= $this->pages || $this->pages <= 1) {
            Error::add('Wrong page disposition. Current: ' . $this->page . ', total: ' . $this->pages, __FILE__);
            return;
        }

        $items = [];
        // check if total pages count more then 10 or use simple algo
        if ($this->pages > 10) {
            $centerFrom = $this->page-2;
            $centerTo = $this->page+2;
            if ($centerFrom < 0) {
                $centerFrom = 0;
            }

            if ($centerTo > $this->pages) {
                $centerTo = $this->pages;
            }

            $items = $this->generateListing(0, ($centerFrom > 3 ? 3 : ($centerFrom-1))); // 0,1,2,3
            if ($items) {
                $items = array_merge($items, $this->generateSpeacer());
            }

            // ... center-2,center-1,center,center+1,center+2 ...
            $items = array_merge((array)$items, $this->generateListing($centerFrom, $centerTo));
            // n-3,n-2,n-1,n
            $last = $this->generateListing(($this->pages - $centerTo > 3 ? $this->pages-3 : $centerTo+1), $this->pages);

            // @todo: calculate where $centerTo is finishing (>last-3 or not and process this shit!)
            if ($last) {
                $items = array_merge($items, $this->generateSpeacer());
                $items = array_merge($items, $last);
            }
        } else {
            $items = $this->generateListing(0, $this->pages);
        }

        // initialize listing
        $this->listing = Listing::factory('ul', $this->properties)
            ->li($items);
    }

    /**
     * Generate listing array from $start page to $end
     * @param int $start
     * @param int $end
     * @return array|null
     */
    private function generateListing(int $start, int $end): ?array
    {
        if ($end < $start) {
            Error::add('End position seems > then start', __FILE__);
            return null;
        }

        $result = [];
        foreach (range($start, $end) as $page) {
            $url = $this->url;
            if ($page > 0) {
                $url[2]['page'] = $page;
            }

            $result[] = [
                'link' => $url,
                'text' => $page+1,
                'properties' => $this->liProperties,
                'linkProperties' => $this->aProperties,
                'urlEqual' => true
            ];
        }

        return $result;
    }

    /**
     * @return array
     */
    private function generateSpeacer(): array
    {
        return [
            ['link' => ['#'], 'text' => '...']
        ];
    }

    /**
     * Display output html if exist
     * @return null|string
     */
    public function display(): ?string
    {
        if ($this->listing) {
            return $this->listing->display();
        }

        return null;
    }

    /**
     * ::toString magic
     * @return null|string
     */
    public function __toString()
    {
        return $this->display();
    }
}
