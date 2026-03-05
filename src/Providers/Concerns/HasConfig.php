<?php

namespace Skywalker\Support\Providers\Concerns;

use Illuminate\Support\Str;

/**
 * Trait     HasConfig
 *
 * @author   Skywalker <skywalker@example.com>
 */
trait HasConfig
{
    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */

    /**
     * Merge multiple config files into one instance (package name as root key)
     *
     * @var bool
     */
    protected $multiConfigs = false;

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Get config folder.
     */
    protected function getConfigFolder()
    {
        return realpath($this->getBasePath().DIRECTORY_SEPARATOR.'config');
    }

    /**
     * Get config key.
     */
    protected function getConfigKey($withVendor = false, $separator = '.')
    {
        $package = Str::slug($this->getPackageName());

        return $withVendor
            ? Str::slug($this->getVendorName()).$separator.$package
            : $package;
    }

    /**
     * Get config file path.
     */
    protected function getConfigFile()
    {
        return $this->getConfigFolder().DIRECTORY_SEPARATOR."{$this->getPackageName()}.php";
    }

    /**
     * Get the config files (paths).
     *
     * @return array|false
     */
    protected function configFilesPaths()
    {
        return glob($this->getConfigFolder().DIRECTORY_SEPARATOR.'*.php');
    }

    /**
     * Register configs.
     */
    protected function registerConfig($separator = '.')
    {
        $this->multiConfigs
            ? $this->registerMultipleConfigs($separator)
            : $this->registerSingleConfig();
    }

    /**
     * Register a single config file.
     */
    protected function registerSingleConfig()
    {
        $this->mergeConfigFrom($this->getConfigFile(), $this->getConfigKey());
    }

    /**
     * Register all package configs.
     */
    protected function registerMultipleConfigs($separator = '.')
    {
        foreach ($this->configFilesPaths() as $path) {
            $key = $this->getConfigKey(true, $separator).$separator.basename($path, '.php');

            $this->mergeConfigFrom($path, $key);
        }
    }

    /**
     * Publish the config file.
     */
    protected function publishConfig($path = null)
    {
        $this->multiConfigs
            ? $this->publishMultipleConfigs()
            : $this->publishSingleConfig($path);
    }

    /**
     * Publish a single config file.
     */
    protected function publishSingleConfig($path = null)
    {
        $this->publishes([
            $this->getConfigFile() => $path ?: config_path("{$this->getPackageName()}.php"),
        ], $this->getPublishedTags('config'));
    }

    /**
     * Publish multiple config files.
     */
    protected function publishMultipleConfigs()
    {
        $paths = [];
        $package = $this->getConfigKey(true, DIRECTORY_SEPARATOR);

        foreach ($this->configFilesPaths() as $file) {
            $paths[$file] = config_path($package.DIRECTORY_SEPARATOR.basename($file));
        }

        $this->publishes($paths, $this->getPublishedTags('config'));
    }
}
