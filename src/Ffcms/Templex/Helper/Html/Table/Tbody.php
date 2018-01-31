<?php

namespace Ffcms\Templex\Helper\Html\Table;


use Ffcms\Templex\Helper\Html\Dom;

class Tbody implements RenderElement
{
    private $properties;
    private $items;

    /** @var Selectize */
    private $selectize;

    /**
     * Tbody constructor.
     * @param array|null $properties
     * @param array $items
     */
    public function __construct(?array $properties = null, array $items)
    {
        $this->properties = $properties;
        $this->items = $items;
    }

    /**
     * Pass inside selectize options
     * @param int $order
     * @param strign $name
     * @return string
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

        return $dom->tbody(function() use ($dom) { // build <tbody></tbody> section
            $tr = null;
            foreach ($this->items as $row) {
                ksort($row); // sort columns in row
                $tr .= $dom->tr(function() use ($dom, $row){ // build <tr></tr> section in <tbody>
                    $td = null;
                    foreach ($row as $order => $column) {
                        // do not process empty rows
                        if (!isset($column['text'])) {
                            return null;
                        }

                        if (!is_int($order)) { // do not process shitty-formatted rows
                            continue;
                        }

                        $td .= $dom->td(function() use ($order, $column) { // build <td><td> tags inside <tr> section
                            $text = $column['text'];
                            $flag = ENT_QUOTES;
                            if (isset($column['flag'])) {
                                $flag = $column['flag'];
                            }

                            if (!$column['html']) {
                                $text = htmlentities($text, $flat, 'UTF-8');
                            }

                            // process selectize features
                            if ($this->selectize && $this->selectize->order() === $order) {
                                $text = $this->processSelectize($text);
                            }

                            return $text;
                        }, $column['properties']);
                    }
                    return $td;
                }, $row['properties']);
            }
            return $tr;
        }, $this->properties);
    }

    /**
     * Process selectize checkboxes
     * @param string|null $text
     */
    private function processSelectize(?string $text): ?string
    {
        $checkbox = (new Dom())->input([
            'value' => $text,
            'type' => 'checkbox',
            'name' => $this->selectize->name() . '[]'
        ]);
        return $checkbox . $text;
    }

}