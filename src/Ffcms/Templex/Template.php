<?php

namespace Ffcms\Templex;

use Ffcms\Templex\Engine\Renderer;
use Ffcms\Templex\Helper\Html\Dom;
use Ffcms\Templex\Helper\Html\Table;


/**
 * Class Template. Template engine loader entry point.
 * @package Ffcms\Templex
 * @example (new Template())->render('user/index', [params], /var/path/default)
 */
class Template
{
    const SECTION_SET = 1;
    const SECTION_APPEND = 2;
    const SECTION_PREPEND = 3;

    private $dir;

    private $sections;

    /**
     * Template constructor. Construct instance with basepath or not
     * @param string $tplDir
     */
    public function __construct(string $tplDir)
    {
        $this->dir = $tplDir;
    }

    /**
     * Get template absolute path
     * @return string
     */
    public function getTemplatePath()
    {
        return $this->dir;
    }

    /**
     * Render output template code with variable compilation
     * @param string $slug
     * @param array|null $params
     * @param null|string $fallbackDir
     * @return null|string
     */
    public function render(string $slug, ?array $params = null, ?string $fallbackDir = null): ?string
    {
        // build full path
        $slug = trim($slug, '/');
        $dir = $this->dir . '/' . $slug . '.php';

        // test if file exist
        if (!is_file($dir)) {
            // try to set fallback if no templates used
            $dir = $fallbackDir . '/' . $slug . '.php';
        }

        $renderer = new Renderer($dir, $this);
        return $renderer->inc($params);
    }

    /**
     * Get section code in layouts or abstractions
     * @param string $name
     * @return null|string
     */
    public function getSection(string $name): ?string
    {
        return $this->sections[$name];
    }

    /**
     * Start buffering section
     * @param string $name
     * @param int $type
     */
    public function section(string $name, int $type = self::SECTION_SET): void
    {
        ob_start(function($buffer) use ($name, $type) {
            //global $this;
            switch ($type) {
                case static::SECTION_SET:
                    $this->sections[$name] = $buffer;
                    break;
                case static::SECTION_APPEND:
                    $this->sections[$name] .= $buffer;
                    break;
                case static::SECTION_PREPEND:
                    $this->sections[$name] = $buffer . $this->sections[$name];
                    break;
            }
        });
    }

    /**
     * End buffering section and set content
     */
    public function stop(): void
    {
        ob_end_flush();
    }

    /**
     * Alias to stop() section method
     */
    public function close(): void
    {
        $this->stop();
    }

    /**
     * Get DOM builder instance
     * @return Dom
     */
    public function dom(): Dom
    {
        return (new Dom());
    }

    /**
     * Get table instance
     * @param array|null $properties
     * @return Table
     */
    public function table(?array $properties = null): Table
    {
        return Table::factory($properties);
    }


}