<?php

namespace Ffcms\Templex\Helper\Html\Bootstrap4;


use Ffcms\Core\Helper\Type\Str;
use Ffcms\Templex\Helper\Html\Dom;
use Ffcms\Templex\Url\Url;

/**
 * Class ButtonGroup. Build bootstrap btn group
 * @package Ffcms\Templex\Helper\Html\Bootstrap4
 */
class ButtonGroup
{
    private $properties;
    private $buttons;

    private $dropdownLimit;

    /**
     * ButtonGroup constructor.
     * @param array|null $properties
     * @param int $dropdownLimit
     */
    public function __construct(?array $properties = null, int $dropdownLimit = 3)
    {
        $this->dropdownLimit = $dropdownLimit;
        if ($properties) {
            $this->properties = $properties;
        }

        if (!isset($this->properties['class'])) {
            $this->properties['class'] = 'btn-group';
        }

        if (!isset($this->properties['role'])) {
            $this->properties['role'] = 'group';
        }
        
        if (!isset($this->properties['dropdown']['class'])) {
            $this->properties['dropdown']['class'] = 'btn-group';
        }

        if (!isset($this->properties['dropdown']['link']['class'])) {
            $this->properties['dropdown']['link']['class'] = 'dropdown-item';
        }

        if (!isset($this->properties['dropdown']['button']['id'])) {
            $this->properties['dropdown']['id'] = 'btngroup-dropdown-' . Str::randomLatin(mt_rand(3,6)) . mt_rand(100, 999);
        }

        $this->properties['dropdown']['button']['type'] = 'button';
        $this->properties['dropdown']['button']['class'] = 'btn btn-secondary dropdown-toggle';
        $this->properties['dropdown']['button']['data-toggle'] = 'dropdown';
    }

    /**
     * Class factory implementation
     * @param array|null $properties
     * @param int $dropdownLimit
     * @return ButtonGroup
     */
    public static function factory(?array $properties = null, int $dropdownLimit = 3): self
    {
        return new self($properties, $dropdownLimit);
    }

    /**
     * @param string $text
     * @param array $link
     * @param array|null $properties
     * @return ButtonGroup
     */
    public function add(string $text, array $link, ?array $properties = null): self
    {
        if (!isset($properties['class'])) {
            $properties['class'] = 'btn btn-light';
        }

        $this->buttons[] = [
            'text' => $text,
            'link' => $link,
            'properties' => $properties
        ];
        return $this;
    }

    /**
     * Display html dropdown button group
     * @return string|null
     */
    public function display(): ?string
    {
        if (count($this->buttons) < 1) {
            return null;
        }

        // draw btn-group menu with dropdown if required
        return (new Dom())->div(function() {
            $html = null;
            $dropdownHtml = null;
            $i = 1;
            foreach ($this->buttons as $button) {
                // if dropdown limit overhead - display dropdown menu
                if ($i > $this->dropdownLimit) {
                    $dropdownHtml .= Url::a($button['link'], $button['text'], $this->properties['dropdown']['link']);
                } else {
                    $html .= Url::a($button['link'], $button['text'], $button['properties']);
                }
                $i++;
            }

            // draw dropdown elements if required
            if ($i > $this->dropdownLimit+1) {
                $html .= (new Dom())->div(function() use ($dropdownHtml) {
                    $html = (new Dom())->button(function() {
                        return "&nbsp;";
                    }, $this->properties['dropdown']['button']);
                    $html .= (new Dom())->div(function() use ($dropdownHtml){
                        return $dropdownHtml;
                    }, ['class' => 'dropdown-menu']);
                    return $html;
                }, ['class' => $this->properties['dropdown']['class'], 'role' => 'group']);
            }

            return $html;
        }, $this->properties);
    }
}