<?php

namespace Skywalker\Support\Providers\Concerns;

/**
 * Trait     HasMigrations
 *
 * @author   Skywalker <skywalker@example.com>
 */
trait HasMigrations
{
    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Get the migrations path.
     */
    protected function getMigrationsPath()
    {
        return $this->getBasePath().DIRECTORY_SEPARATOR.'database'.DIRECTORY_SEPARATOR.'migrations';
    }

    /**
     * Publish the migration files.
     */
    protected function publishMigrations($path = null)
    {
        $this->publishes([
            $this->getMigrationsPath() => $path ?: database_path('migrations'),
        ], $this->getPublishedTags('migrations'));
    }

    /**
     * Load the migrations files.
     */
    protected function loadMigrations()
    {
        $this->loadMigrationsFrom($this->getMigrationsPath());
    }
}
