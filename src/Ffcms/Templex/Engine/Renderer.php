<?php

namespace Ffcms\Templex\Engine;


use Ffcms\Templex\Template;

/**
 * Class Renderer. Render template file with passed params
 * @package Ffcms\Templex\Engine
 * @property $title
 * @property $breadcrumbs
 * @property $description
 * @property $keywords
 */
class Renderer
{
    private $path;

    /** @var Template */
    private $_template;

    /**
     * Renderer constructor.
     * @param string $absPath
     * @param Template $template
     */
    public function __construct(string $absPath, Template $template)
    {
        $this->path = $absPath;
        $this->_template = $template;
    }

    /**
     * Get template instance
     * @return Template
     */
    public function view()
    {
        return $this->_template;
    }

    /**
     * Render output template as string
     * @param array|null $params
     * @return string|null
     */
    public function inc(array $params = null): ?string
    {
        // check if path exist and executable
        if (!$this->path || !is_file($this->path)) {
            return null;
        }

        // assert variables
        if ($params && is_iterable($params)) {
            foreach ($params as $var => $value) {
                // assert as variable in current access namespace
                ${$var} = $value;
            }
        }

        $tpl = $this->_template;
        $global = $this->buildGlobals();


        $result = null;
        ob_start();
        try {
            include($this->path);
            $result = ob_get_clean();
        } catch (\Exception $e) {
            ob_end_clean();
        }

        return $result;
    }

    /**
     * Render over renderer instance. Please, use $renderer->view()->render() instead of this method
     * @param string $slug
     * @param array|null $params
     * @param null|string $fallback
     * @return null|string
     * @deprecated
     */
    public function render(string $slug, ?array $params = null, ?string $fallback = null)
    {
        return $this->_template->render($slug, $params, $fallback);
    }

    /**
     * Build fake object for global variables
     * @return \stdClass
     */
    private function buildGlobals()
    {
        $fake = new \stdClass();
        foreach (Vars::instance()->getGlobalsObject() as $var => $value) {
            $fake->{$var} = $value;
        }
        return $fake;
    }

    /**
     * Set global variable
     * @param $name
     * @param $value
     */
    public function __set($name, $value)
    {
        Vars::instance()->setGlobal($name, $value);
    }

    /**
     * Get global variable
     * @param $name
     * @return null
     */
    public function __get($name)
    {
        $globals = Vars::instance()->getGlobalsArray();
        return array_key_exists($name, $globals) ? $globals[$name] : null;
    }

}