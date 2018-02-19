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

    /** @var Selectize */
    private $selectize;
    /** @var Sorter */
    private $sorter;

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
     * Pass selectize instance inside
     * @param Selectize $selectize
     */
    public function initSelectize(Selectize $selectize): void
    {
        $this->selectize = $selectize;
    }

    /**
     * Pass sorter inside
     * @param Sorter $sorter
     */
    public function initSorter(Sorter $sorter): void
    {
        $this->sorter = $sorter;
    }

    /**
     * @inheritdoc
     * @return null|string|void
     */
    public function html(): ?string
    {
        $dom = new Dom();
        return $dom->thead(function () use ($dom) { // make <thead></thead> section
            return $dom->tr(function () use ($dom) { // make <tr></tr> section inside <thead>
                $tr = null;
                foreach ($this->items as $order => $item) {
                    $tr .= $dom->th(function () use ($dom, $item, $order) { // make <th></th> items inside <tr> section
                        // parse th text from passed item array value
                        $text = (string)$item['text'];
                        if (!$item['html']) {
                            $flag = ENT_QUOTES; // set escape quotas flag for htmlentities if not defined
                            if (isset($item['flag'])) {
                                $flag = $item['flag'];
                            }
                            $text = htmlspecialchars($text, $flag, 'UTF-8');
                        }

                        // check if selectize used and apply it
                        if ($this->selectize && $this->selectize->order() === $order) {
                            $text = $this->processSelectize($text);
                        }

                        // process sorter elements
                        if ($this->sorter) {
                            $text .= $this->sorter->getColumnSorters($order);
                        }

                        return $text; // <th>text</th>
                    }, $item['properties']);
                }
                return $tr;
            });
        }, $this->properties);
    }

    /**
     * Process selectize features for head
     * @param null|string $text
     */
    private function processSelectize(?string $text): ?string
    {
        $input = (new Dom())->input([
            'type' => 'checkbox',
            'name' => $this->selectize->name() . 'All'
        ]);

        return $input . $text;
    }
}
