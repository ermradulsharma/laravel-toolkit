<?php

namespace Skywalker\Support\Providers\Concerns;

/**
 * Trait     HasTranslations
 *
 * @author   Skywalker <skywalker@example.com>
 */
trait HasTranslations
{
    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Get the translations' folder name.
     */
    protected function getTranslationsFolderName()
    {
        return 'translations';
    }

    /**
     * Get the translations' path.
     */
    protected function getTranslationsPath()
    {
        return $this->getBasePath().DIRECTORY_SEPARATOR.$this->getTranslationsFolderName();
    }

    /**
     * Get the destination views path.
     */
    protected function getTranslationsDestinationPath()
    {
        return $this->app->langPath(
            'vendor'.DIRECTORY_SEPARATOR.$this->getPackageName()
        );
    }

    /**
     * Publish the translations.
     */
    protected function publishTranslations($path = null)
    {
        $this->publishes([
            $this->getTranslationsPath() => $path ?: $this->getTranslationsDestinationPath(),
        ], $this->getPublishedTags('translations'));
    }

    /**
     * Load the translations files.
     */
    protected function loadTranslations()
    {
        $packagePath = $this->getTranslationsPath();
        $vendorPath = $this->getTranslationsDestinationPath();

        $this->loadTranslationsFrom($packagePath, $this->getPackageName());
        $this->loadJsonTranslationsFrom(file_exists($vendorPath) ? $vendorPath : $packagePath);
    }
}
