<?php

namespace Ffcms\Templex\Helper\Html\Table;

use Ffcms\Templex\Exceptions\Error;
use Ffcms\Templex\Helper\Html\Dom;

/**
 * Class Tbody. Process tbody container in table
 * @package Ffcms\Templex\Helper\Html\Table
 */
class Tbody implements RenderElement
{
    /** @var array */
    private $properties;
    /** @var array */
    private $items = [];

    /** @var Selectize */
    private $selectize;

    /**
     * Set tbody element properties
     * @param array $properties
     */
    public function setProperties(array $properties)
    {
        $this->properties = $properties;
    }

    /**
     * Add row items in array
     * @param array $items
     */
    public function addItems(array $items)
    {
        // array += array save key ordering instead of array_merge func
        $this->items += $items;
    }

    /**
     * Add item in items array
     * @param array $item
     * @param int|null $idx
     */
    public function addItem(array $item, ?int $idx = null)
    {
        if ($idx === null) {
            $this->items[] = $item;
        } elseif (isset($this->items[$idx])) {
            $this->addItem($item, $idx++);
        } else {
            $this->items[$idx] = $item;
        }
    }

    /**
     * Pass inside selectize options
     * @param Selectize $selectize
     */
    public function initSelectize(Selectize $selectize)
    {
        $this->selectize = $selectize;
    }

    /**
     * Get output html
     * @return null|string
     */
    public function html(): ?string
    {
        $dom = new Dom();

        return $dom->tbody(function () use ($dom) { // build <tbody></tbody> section
            $tr = null;
            ksort($this->items); // sort rows by index
            foreach ($this->items as $row) {
                ksort($row); // sort columns in row by index
                $rowProperties = $row['properties'] ?? null;
                unset($row['properties']);
                $tr .= $dom->tr(function () use ($dom, $row) { // build <tr></tr> section in <tbody>
                    $td = null;
                    foreach ($row as $order => $column) {
                        // do not process shitty-formatted rows or key-based properties
                        if (!is_int($order)) {
                            Error::add('Table row is wrong by key: ' . $order, __LINE__);
                            continue;
                        }

                        $text = $column['text'] ?? null;
                        // do not process empty rows
                        if (!isset($text)) {
                            Error::add('Table row have no "text" property in order: ' . $order, __LINE__);
                            return null;
                        }

                        $td .= $dom->td(function () use ($order, $column, $text) { // build <td><td> tags inside <tr> section
                            $flag = $column['flag'] ?? ENT_QUOTES;
                            if (!(bool)($column['html'] ?? false)) {
                                $text = htmlspecialchars($text, $flag, 'UTF-8');
                            }

                            // process selectize features
                            if ($this->selectize && $this->selectize->order() === $order) {
                                $text = $this->processSelectize($text);
                            }

                            return $text;
                        }, ($column['properties'] ?? null));
                    }
                    return $td;
                }, $rowProperties);
            }
            return $tr;
        }, $this->properties);
    }

    /**
     * Process selectize checkboxes
     * @param string|null $text
     * @return string|null
     */
    private function processSelectize(?string $text): ?string
    {
        $checkbox = (new Dom())->input([
            'value' => $text,
            'type' => 'checkbox',
            'name' => $this->selectize->name() . '[]'
        ]);
        return $checkbox . ' ' .  $text;
    }
}
