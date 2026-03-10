<?php

namespace Skywalker\Support\Providers\Concerns;

/**
 * Trait     HasViews
 *
 * @author   Skywalker <skywalker@example.com>
 *
 * @method string getBasePath()
 * @method string getPackageName()
 * @method array<int, string> getPublishedTags(string $tag)
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
    protected function getViewsPath(): string
    {
        return $this->getBasePath().DIRECTORY_SEPARATOR.'views';
    }

    /**
     * Get the destination views path.
     */
    protected function getViewsDestinationPath(): string
    {
        $viewPaths = config('view.paths', []);
        /** @phpstan-ignore-next-line */
        $baseResourcePath = is_array($viewPaths) && ! empty($viewPaths) ? strval(array_values($viewPaths)[0]) : resource_path('views');

        return $baseResourcePath.DIRECTORY_SEPARATOR.'vendor'.DIRECTORY_SEPARATOR.$this->getPackageName();
    }

    /**
     * Publish the views.
     */
    protected function publishViews(?string $path = null): void
    {
        $this->publishes([
            $this->getViewsPath() => $path ?: $this->getViewsDestinationPath(),
        ], $this->getPublishedTags('views'));
    }

    /**
     * Load the views files.
     */
    protected function loadViews(): void
    {
        $this->loadViewsFrom($this->getViewsPath(), $this->getPackageName());
    }
}
