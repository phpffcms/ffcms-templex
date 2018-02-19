<?php

namespace Ffcms\Templex\Url;

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
        if (!$url || !isset($url[0]) || !is_string($url[0])) {
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
    public function isEqualCurrent(?array $url = null)
    {
        if (!$url[0] || !is_string($url[0]) || strpos($url[0], '/') === false) {
            return false;
        }

        $targetUrl = self::to($url[0], $url[1], $url[2]);

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
        if ($controllerAction[0] === '#' || strpos($controllerAction, '://') !== false) {
            return $controllerAction;
        }

        $controllerAction = trim($controllerAction, '/');
        // @todo: pass url/subdir to instance initialization
        $worker = new self();

        // build base url with path from array
        $url = $worker->repository()->getRoot() . '/';
        $url .= $worker->buildUrlPath([$controllerAction, $arguments, $query]);

        return $url;
    }

    /**
     * Build path from array
     * @param array|null $url
     * @return null|string
     */
    public function buildUrlPath(?array $url = null): ?string
    {
        if (!$url || !isset($url[0]) || !is_string($url[0])) {
            return null;
        }

        $path = trim($url[0], '/');
        // build argument params
        if (isset($url[1]) && is_array($url[1])) {
            foreach ($url[1] as $arg) {
                $path .= '/' . $arg;
            }
        }
        // build query string
        if (isset($url[2]) && is_array($url[2])) {
            $path .= '?' . http_build_query($url[2]);
        }

        return $path;
    }
}
