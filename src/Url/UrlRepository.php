<?php

namespace Ffcms\Templex\Url;

/**
 * Class UrlRepository. Url properties factory and instance holder
 * @package Ffcms\Templex\Url
 */
class UrlRepository
{
    protected static $instance;

    private $current;
    private $parse;

    private $subdir;
    private $root;

    /**
     * UrlRepository constructor.
     */
    public function __construct()
    {
        // if not passed direct - try to get from PHP params
        if (!$this->current) {
            $host = $_SERVER['HTTP_HOST'] ?? null;
            $uri = $_SERVER['REQUEST_URI'] ?? null;

            $this->current = 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . "://" . $host . $uri;
        }

        $this->prepareRootUrl();
    }

    /**
     * Entry point like singleton state holder.
     * @return UrlRepository
     */
    public static function factory(): UrlRepository
    {
        if (!self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }


    /**
     * Set custom url and subdir
     * @param null|string $url
     * @param null|string $subdir
     * @return void
     */
    public function setUrlAndSubdir(?string $url = null, ?string $subdir = null): void
    {
        if ($url) {
            $this->current = $url;
        }

        if ($subdir) {
            $this->subdir = $subdir;
        }

        if ($url || $subdir) {
            $this->prepareRootUrl();
        }
    }


    /**
     * Prepare main root url
     * @return void
     */
    private function prepareRootUrl(): void
    {
        $this->parse = parse_url($this->current);
        $this->root = $this->parse['scheme'] . '://' . $this->parse['host'];
        if (isset($this->parse['port'])) {
            $this->root .= ':' . $this->parse['port'];
        }
        if ($this->subdir) {
            $this->root .= '/' . trim($this->subdir, '/');
        }
    }

    /**
     * Get root url (scheme + host)
     * @return string|null
     */
    public function getRoot(): ?string
    {
        return $this->root;
    }

    /**
     * Get current url
     * @return string
     */
    public function getCurrent(): ?string
    {
        return $this->current;
    }

    /**
     * Get current path without subdir definition
     * @return null|string
     */
    public function getPath(): ?string
    {
        $path = trim($this->parse['path'], '/');
        if ($this->subdir) {
            $path = mb_substr($path, mb_strlen($this->subdir));
            $path = rtrim($path, '/');
        }

        return $path;
    }
}
