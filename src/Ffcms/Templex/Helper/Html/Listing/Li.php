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
        if (!isset($thix->context['active']['class'])) {
            $this->context['active']['class'] = 'active';
        }

        // 0 = controller/action, 1 = [argument array], 2 = [get query array]
        $url = Url::to($this->context['link'][0], $this->context['link'][1], $this->context['link'][2]);

        // return element
        return (new Dom())->li(function () use ($url) { // <li><li> container
            $ahrefProperties = array_merge(['href' => $url], (array)$this->context['linkProperties']);
            // check if link seems like current and mark "active"
            if (is_array($this->context['link']) && $this->isCurrentUrl($this->context['link'], (bool)$this->context['urlEqual'])) {
                $ahrefProperties['class'] .= ' ' . $this->context['active']['class'];
            }

            return (new Dom())->a(function () use ($url) { // <a href="">{val}</a> container inside <li>
                $text = $this->context['text'];
                if (is_callable($text)) {
                    $text = $text();
                }
                if (!$this->context['html']) {
                    $text = htmlentities($text, null, 'UTF-8');
                }

                return $text;
            }, $ahrefProperties);
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
            $text = $this->context;
            if (!$this->properties['html']) {
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
    public function __toString(): ?string
    {
        return $this->html();
    }
}
