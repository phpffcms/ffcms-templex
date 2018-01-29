<?php

namespace Ffcms\Templex\Helper\Html\Table;


use Ffcms\Templex\Helper\Html\Dom;

class Thead implements RenderElement
{
    /**
     * @var array|null
     */
    private $properties;

    /** @var array */
    private $items;

    /**
     * Thead constructor. Build thead instance
     * @param array|null $properties
     * @param array|null $items
     */
    public function __construct(?array $properties = null, array $items)
    {
        $this->properties = $properties;
        $this->items = $items;
    }

    /**
     * @inheritdoc
     * @return null|string|void
     */
    public function html()
    {
        $dom = new Dom();
        return $dom->thead(function() use ($dom) { // make <thead></thead> section
            return $dom->tr(function() use ($dom){ // make <tr></tr> section inside <thead>
                $tr = null;
                foreach ($this->items as $order => $item) {
                    $tr .= $dom->th(function() use ($dom, $item, $order) { // make <th></th> items inside <tr> section
                        $text = (string)$item['text'];
                        if (!$item['html']) {
                            $flag = ENT_QUOTES; // set escape quotas flag for htmlentities if not defined
                            if (isset($item['flag'])) {
                                $flag = $item['flag'];
                            }
                            $text = htmlentities($text, $flag, 'UTF-8');
                        }
                        return $text; // <th>text</th>
                    }, $item['properties']);
                }
            });
        }, $this->properties);
    }
}