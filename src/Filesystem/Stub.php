<?php

namespace Skywalker\Support\Filesystem;

/**
 * Class     Stub
 *
 * @author   Skywalker <skywalker@example.com>
 */
class Stub
{
    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */

    /**
     * The stub path.
     *
     * @var string
     */
    protected $path;

    /**
     * The base path of stub file.
     *
     * @var string|null
     */
    protected static $basePath = null;

    /**
     * The replacements array.
     *
     * @var array<string, string>
     */
    protected $replaces = [];

    /* -----------------------------------------------------------------
     |  Constructor
     | -----------------------------------------------------------------
     */

    /**
     * Create a new instance.
     *
     * @param  string  $path
     * @param  array<string, string>  $replaces
     */
    public function __construct($path, array $replaces = [])
    {
        $this->setPath($path);
        $this->setReplaces($replaces);
    }

    /* -----------------------------------------------------------------
     |  Getters & Setters
     | -----------------------------------------------------------------
     */

    /**
     * Get stub path.
     *
     * @return string
     */
    public function getPath()
    {
        $path = $this->path;

        if (! empty(static::$basePath)) {
            $path = static::$basePath.DIRECTORY_SEPARATOR.ltrim($path, DIRECTORY_SEPARATOR);
        }

        return $path;
    }

    /**
     * Set stub path.
     *
     * @param  string  $path
     * @return $this
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get base path.
     *
     * @return string|null
     */
    public static function getBasePath()
    {
        return static::$basePath;
    }

    /**
     * Set base path.
     *
     * @param  string  $path
     * @return void
     */
    public static function setBasePath($path): void
    {
        static::$basePath = $path;
    }

    /**
     * Get replacements.
     *
     * @return array<string, string>
     */
    public function getReplaces()
    {
        return $this->replaces;
    }

    /**
     * Set replacements array.
     *
     * @param  array<string, string>  $replaces
     * @return $this
     */
    public function setReplaces(array $replaces = [])
    {
        $this->replaces = $replaces;

        return $this;
    }

    /**
     * Set replacements array.
     *
     * @param  array<string, string>  $replaces
     * @return $this
     */
    public function replaces(array $replaces = [])
    {
        return $this->setReplaces($replaces);
    }

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Create new self instance.
     *
     * @param  string  $path
     * @param  array<string, string>  $replaces
     * @return static
     */
    public static function create($path, array $replaces = [])
    {
        return new static($path, $replaces);
    }

    /**
     * Create new self instance from full path.
     *
     * @param  string  $path
     * @param  array<string, string>  $replaces
     * @return static
     */
    public static function createFromPath($path, array $replaces = [])
    {
        $stub = new static($path, $replaces);

        return tap($stub, function ($instance) {
            /** @var static $instance */
            $instance->setBasePath('');
        });
    }

    /**
     * Get stub contents.
     *
     * @return string
     */
    public function render()
    {
        return $this->getContents();
    }

    /**
     * Save stub to base path.
     *
     * @param  string  $filename
     * @return bool
     */
    public function save($filename)
    {
        return $this->saveTo(static::getBasePath(), $filename);
    }

    /**
     * Save stub to specific path.
     *
     * @param  string|null  $path
     * @param  string  $filename
     * @return bool
     */
    public function saveTo($path, $filename)
    {
        $base = $path ?: '';

        return file_put_contents($base.DIRECTORY_SEPARATOR.$filename, $this->render()) !== false;
    }

    /**
     * Get stub contents.
     *
     * @return string
     */
    public function getContents()
    {
        $contents = (string) @file_get_contents($this->getPath());

        foreach ($this->getReplaces() as $search => $replace) {
            $contents = str_replace('$'.strtoupper((string) $search).'$', (string) $replace, $contents);
        }

        return $contents;
    }

    /**
     * Handle magic method __toString.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->render();
    }
}
