<?php

namespace Ffcms\Templex\Url;


class Url
{
    /** @var UrlRepository */
    private $repository;

    public function __construct(?string $url = null, ?string $subdir = null)
    {
        $this->repository = UrlRepository::factory();
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
     * @param string $path
     */
    public function isLikeCurrent(string $path)
    {
        $current = $this->repository->getPath();
        $path = trim($path, '/');

        return mb_substr($current, 0, mb_strlen($path)) === $path;
    }

    public function isEqualCurrent(?array $url = null)
    {
        
    }
}