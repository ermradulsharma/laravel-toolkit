<?php

namespace Skywalker\Support\Providers\Concerns;

/**
 * Trait     HasAssets
 *
 * @author   Skywalker <skywalker@example.com>
 */
trait HasAssets
{
    /* -----------------------------------------------------------------
     |  Getters & Setters
     | -----------------------------------------------------------------
     */

    /**
     * Get the assets path.
     */
    protected function getAssetsFolder()
    {
        return realpath($this->getBasePath().DIRECTORY_SEPARATOR.'assets');
    }

    /**
     * Get the assets destination path.
     */
    protected function assetsDestinationPath()
    {
        return base_path('assets'.DIRECTORY_SEPARATOR.$this->getPackageName());
    }

    /**
     * Publish the assets.
     */
    protected function publishAssets()
    {
        $this->publishes([
            $this->getAssetsFolder() => $this->assetsDestinationPath(),
        ], $this->getPublishedTags('assets'));
    }
}
