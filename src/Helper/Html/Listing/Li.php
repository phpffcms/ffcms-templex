<?php

namespace Ffcms\Templex\Helper\Html\Listing;

use Ffcms\Templex\Helper\Html\Dom;
use Ffcms\Templex\Url\Url;

/**
 * Class Li. Build <li> element
 * @package Ffcms\Templex\Helper\Html\Listing
 */
class Li
{
    private $context;
    private $properties;

    private $html;

    /**
     * Li constructor. Initialize container
     * @param $context
     * @param array|null $properties
     */
    public function __construct($context, ?array $properties = null)
    {
        $this->context = $context;
        $this->properties = $properties;
        $this->make();
    }

    /**
     * Build result html
     */
    private function make(): void
    {
        if (is_array($this->context)) {
            if (isset($this->context['link']) && isset($this->context['text'])) { // link item
                $this->html = $this->buildLinkItem();
            } elseif (isset($this->context['text']) && isset($this->context['tab'])) { // tab content item
                $this->html = null; // @todo!!!
            } elseif (isset($this->context['dropdown']) && isset($this->context['text'])) {
                // dropdown bootstrap implementation
                $this->html = $this->buildDivDropdownItem();
            }
        } else {
            $this->html = $this->buildTextItem();
        }
    }

    /**
     * Build html "a href" link with checking if current url equals to
     * @return string|null
     */
    private function buildLinkItem(): ?string
    {
        // check if active class defined by input or set as default
        if (!isset($this->context['active']['class'])) {
            $this->context['active']['class'] = 'active';
        }

        // 0 = controller/action, 1 = [argument array], 2 = [get query array]
        $url = Url::link((array)$this->context['link']);

        // return element
        return (new Dom())->li(function () use ($url) { // <li><li> container
            $ahrefProperties = array_merge(['href' => $url], (array)($this->context['linkProperties'] ?? []));
            // check if link seems like current and mark "active"
            if (isset($this->context['link']) && is_array($this->context['link']) && $this->isCurrentUrl($this->context['link'], (bool)($this->context['urlEqual'] ?? false))) {
                $ahrefProperties['class'] .= ' ' . $this->context['active']['class'];
            }

            return (new Dom())->a(function () use ($url) { // <a href="">{val}</a> container inside <li>
                $text = $this->context['text'] ?? null;
                if (is_callable($text) && !is_string($text)) {
                    $text = $text();
                }
                if (!(bool)($this->context['html'] ?? false)) {
                    $text = htmlentities($text, null, 'UTF-8');
                }

                return $text;
            }, $ahrefProperties);
        }, $this->properties);
    }

    /**
     * Build html code for dropdown div->a elements as li>a div [a]
     * @return null|string
     */
    private function buildDivDropdownItem(): ?string
    {
        if (isset($this->context['dropdown']) && !is_array($this->context['dropdown']) || count($this->context['dropdown']) < 1) {
            return null;
        }
        // get dropdown header & items
        $items = $this->context['dropdown'] ?? null;
        $text = $this->context['text'] ?? null;

        // build output html code
        return (new Dom())->li(function () use ($items, $text) {
            if (!isset($this->properties['anchor']['id'])) {
                $this->properties['anchor']['id'] = 'auto-dropdown-div-' . mt_rand(0, 1000000);
            }
            // build link anchor with text & dropdown id
            $html = (new Dom())->a(function () use ($text) {
                if (!(bool)($this->properties['html'] ?? false)) {
                    $text = htmlentities($text, null, 'UTF-8');
                }
                return $text;
            }, ($this->properties['anchor'] ?? null));
            // build dropdown div construction
            $html .= (new Dom())->div(function () use ($items) {
                $output = null;
                foreach ($items as $item) {
                    if (!isset($item['text']) || !isset($item['link'])) {
                        continue;
                    }
                    // build dropdown link in dropdown block
                    $link = Url::link($item['link']);
                    $text = $item['text'];
                    unset($item['link'], $item['text']);
                    $item['href'] = $link;
                    $output .= (new Dom())->a(function () use ($text, $item) {
                        if (!(bool)($item['html'] ?? false)) {
                            $text = htmlentities($text, null, 'UTF-8');
                        }
                        return $text;
                    }, $item);
                }

                return $output;
            }, ($this->properties['container'] ?? null));


            return $html;
        }, $this->properties);
    }

    /**
     * Compare if $link array is equal to current pathway
     * @param array $link
     * @param bool $hardCompare
     * @return bool
     */
    private function isCurrentUrl(array $link, bool $hardCompare = false)
    {
        $url = new Url();
        return ($hardCompare ? $url->isEqualCurrent($link) : $url->isLikeCurrent($link));
    }

    /**
     * Build text item
     * @return string
     */
    private function buildTextItem()
    {
        // build text item dom element
        return (new Dom())->li(function () {
            $text = $this->context ?? null;
            if (!(bool)($this->properties['html'] ?? false)) {
                $text = htmlspecialchars($text, null, 'UTF-8');
            }

            return $text;
        }, $this->properties);
    }

    /**
     * Return compiled html code
     * @return null|string
     */
    public function html(): ?string
    {
        return $this->html;
    }

    /**
     * Magic __toString call
     * @return null|string
     */
    public function __toString(): string
    {
        return $this->html();
    }
}
