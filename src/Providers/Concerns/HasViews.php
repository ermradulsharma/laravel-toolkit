<?php

namespace Skywalker\Support\Providers\Concerns;

/**
 * Trait     HasViews
 *
 * @author   Skywalker <skywalker@example.com>
 */
trait HasViews
{
    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Get the base views path.
     */
    protected function getViewsPath()
    {
        return $this->getBasePath().DIRECTORY_SEPARATOR.'views';
    }

    /**
     * Get the destination views path.
     */
    protected function getViewsDestinationPath()
    {
        return $this->app['config']['view.paths'][0].DIRECTORY_SEPARATOR.'vendor'.DIRECTORY_SEPARATOR.$this->getPackageName();
    }

    /**
     * Publish the views.
     */
    protected function publishViews($path = null)
    {
        $this->publishes([
            $this->getViewsPath() => $path ?: $this->getViewsDestinationPath(),
        ], $this->getPublishedTags('views'));
    }

    /**
     * Load the views files.
     */
    protected function loadViews()
    {
        $this->loadViewsFrom($this->getViewsPath(), $this->getPackageName());
    }
}
