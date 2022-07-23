<?php

namespace Ffcms\Templex\Url;

use Ffcms\Core\App;
use Ffcms\Core\Helper\Type\Str;
use Ffcms\Templex\Helper\Html\Dom;

/**
 * Class Url. Build urls inside project
 * @package Ffcms\Templex\Url
 */
class Url
{
    /** @var UrlRepository */
    private $repository;

    public function __construct(?string $url = null, ?string $subdir = null)
    {
        $this->repository = UrlRepository::factory();
        $this->repository->setUrlAndSubdir($url, $subdir);
    }

    /**
     * Get repository instance
     * @return UrlRepository
     */
    public function repository()
    {
        return $this->repository;
    }

    /**
     * Check if $url is seems like current url
     * @param array|null $url
     * @return bool
     */
    public function isLikeCurrent(?array $url = null): bool
    {
        $element = new UrlElement($url);
        if (!$url || !$element->getControllerAction()) {
            return false;
        }

        $current = $this->repository->getPath();
        $target = $this->buildUrlPath($url);

        return mb_substr($current, 0, mb_strlen($target)) === $target;
    }

    /**
     * Check if target $url is equal to current
     * @param array|null $url
     * @return bool
     */
    public function isEqualCurrent(?array $url = null): bool
    {
        $element = new UrlElement($url);
        if (!$url || !$element->isValidControllerAction()) {
            return false;
        }

        $targetUrl = self::to($element->getControllerAction(), $element->getParams(), $element->getQuery());

        return $targetUrl === $this->repository->getCurrent();
    }

    /**
     * Build link to url based on array notation
     * @param string $controllerAction
     * @param array|null $arguments
     * @param array|null $query
     * @return string
     */
    public static function to(string $controllerAction, ?array $arguments = null, ?array $query = null): ?string
    {
        // check if link is looks like anchor (starts with #) or full url (contains protocol://)
        //if ($controllerAction[0] === '#' || strpos($controllerAction, '://') !== false) {
        if ($controllerAction[0] === '#') {
            return $controllerAction;
        }

        if (strpos($controllerAction, '://') !== false) {
            if ($query) {
                $controllerAction .= '?' . http_build_query($query);
            }
            return $controllerAction;
        }

        $controllerAction = trim($controllerAction, '/');
        $worker = new self();

        // build base url with path from array
        $url = $worker->repository()->getRoot() . '/';
        $url .= $worker->buildUrlPath([$controllerAction, $arguments, $query]);

        return $url;
    }

    /**
     * Build link from item array
     * @param array $item
     * @return array|null
     */
    public static function link(array $item): ?string
    {
        $element = new UrlElement($item);
        return self::to($element->getControllerAction(), $element->getParams(), $element->getQuery());
    }

    /**
     * Fast build <a href="">text</a> link based on Url helper class
     * @param array $item
     * @param string $text
     * @param array|null $properties
     * @return null|string
     */
    public static function a(array $item, string $text, ?array $properties = null): ?string
    {
        $properties['href'] = self::link($item);
        return (new Dom())->a(function () use ($text, $properties) {
            if (!$properties['html']) {
                $text = htmlspecialchars($text);
            }
            return $text;
        }, $properties);
    }

    /**
     * Build path from array
     * @param array|null $url
     * @return null|string
     */
    public function buildUrlPath(?array $url = null): ?string
    {
        $element = new UrlElement($url);
        if (!$url || !$element->getControllerAction()) {
            return null;
        }

        $path = trim($element->getControllerAction(), '/');
        // build argument params
        if ($element->getParams()) {
            foreach ($element->getParams() as $arg) {
                $path .= '/' . $arg;
            }
        }
        // build query string
        if ($element->getQuery()) {
            $path .= '?' . http_build_query($element->getQuery());
        }

        return $path;
    }

    /**
     * Generate standalone url from uri and config values
     * @param string $uri
     * @param string|null $lang
     * @return string|null
     */
    public static function stringUrl(string $uri, ?string $lang = null): ?string
    {
        /** @var array $configs */
        $configs = App::$Properties->getAll('default');
        $httpHost = $configs['baseProto'] . '://' . $configs['baseDomain'];
        if ($configs['basePath'] !== '/') {
            $httpHost .= $configs['basePath'] . '/';
        }

        // check if is this is URI not URL
        if (!Str::startsWith($httpHost, $uri)) {
            // check if lang is defined in URI or define it
            if ($lang && $configs['multiLanguage'] && !Str::startsWith($lang, $uri)) {
                $uri = $lang . '/' . ltrim($uri, '/');
            }
            // add basic httpHost data
            $uri = rtrim($httpHost, '/') . '/' . ltrim($uri, '/');
        }

        return $uri;
    }
}
