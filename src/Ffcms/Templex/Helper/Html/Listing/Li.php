<?php

namespace Ffcms\Templex\Helper\Html\Listing;

use Ffcms\Templex\Helper\Html\Dom;
use Ffcms\Templex\Url\Url;


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
     * Build html "a href" link with checking if current url equals to
     * @param array $item
     */
    private function buildLinkItem(array $item): ?string
    {
        // check if active class defined by input or set as default
        if (!isset($item['active']['class'])) {
            $item['active']['class'] = 'active';
        }

        // 0 = controller/action, 1 = [argument array], 2 = [get query array]
        $url = Url::to($item['link'][0], $item['link'][1], $item['link'][2]);

        // return element
        return (new Dom())->li(function() use ($item, $url){ // <li><li> container
            $ahrefProperties = array_merge(['href' => $url, (array)$item['linkProperties']]);
            // check if link seems like current and mark "active"
            if (is_array($item['link']) && (new Url())->isLikeCurrent($item['link'])) {
                $ahrefProperties = array_merge($ahrefProperties, $item['active']);
            }

            return (new Dom())->a(function() use ($item, $url){ // <a href="">{val}</a> container inside <li>
                $text = $item['text'];
                if (!$item['html']) {
                    $text = htmlentities($text, null, 'UTF-8');
                }

                return $text;
            }, $ahrefProperties);
        }, $item['properties']);
    }

    /**
     * Build text item
     * @param array $item
     * @return string
     */
    private function buildTextItem(array $item)
    {
        // build text item dom element
        return (new Dom())->li(function() use ($item){
            $text = $item['text'];
            if (!$item['html']) {
                $text = htmlspecialchars($text, null, 'UTF-8');
            }

            return $text;
        }, $item['properties']);
    }
}