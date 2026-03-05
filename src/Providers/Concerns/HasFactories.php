<?php

namespace Skywalker\Support\Providers\Concerns;

/**
 * Trait     HasFactories
 *
 * @author   Skywalker <skywalker@example.com>
 */
trait HasFactories
{
    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Get the migrations path.
     */
    protected function getFactoriesPath()
    {
        return $this->getBasePath().DIRECTORY_SEPARATOR.'database'.DIRECTORY_SEPARATOR.'factories';
    }

    /**
     * Publish the factories.
     */
    protected function publishFactories($path = null)
    {
        $this->publishes([
            $this->getFactoriesPath() => $path ?: database_path('factories'),
        ], $this->getPublishedTags('factories'));
    }

    /**
     * Load the factories.
     */
    protected function loadFactories()
    {
        $this->loadFactoriesFrom($this->getFactoriesPath());
    }
}
