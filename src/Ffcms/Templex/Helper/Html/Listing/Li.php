<?php

namespace Ffcms\Templex\Helper\Html\Listing;

use Ffcms\Templex\Helper\Html\Dom;

class Li
{
    private $items;

    /**
     * Li constructor.
     * @param array $items
     */
    public function __construct(array $items)
    {
        $this->items = $items;
    }

    /**
     * Build output html
     * @return null|string
     */
    public function html(): ?string
    {
        $dom = new Dom();

        $html = null;
        foreach ($this->items as $item) {
            // do not process bulls@its
            if (!is_array($item)) {
                continue;
            }

            if (isset($item['link'])) {
                $html .= $this->buildLinkItem($item);
            } else {
                $html .= $this->buildTextItem($item);
            }
        }

        return $html;
    }

    /**
     * Build html
     * @param array $item
     */
    private function buildLinkItem(array $item): ?string
    {
        if (!isset($item['active']['class'])) {
            $item['active']['class'] = 'active';
        }

        // @todo: implement link building features

        return '';
    }

    /**
     * Build text item
     * @param array $item
     * @return string
     */
    private function buildTextItem(array $item)
    {
        return (new Dom())->li(function() use ($item){
            $text = $item['text'];
            if (!$item['html']) {
                $text = htmlentities($text, null, 'UTF-8');
            }

            return $text;
        }, $item['properties']);
    }
}