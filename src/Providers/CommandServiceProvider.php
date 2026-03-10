<?php

namespace Skywalker\Support\Providers;

/**
 * Class     CommandServiceProvider
 *
 * @author   Skywalker <skywalker@example.com>
 */
abstract class CommandServiceProvider extends ServiceProvider
{
    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */

    /**
     * The commands to be registered.
     *
     * @var array<int, class-string>
     */
    protected $commands = [];

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Boot the service provider.
     */
    public function boot(): void
    {
        $this->commands($this->commands);
    }

    /**
     * Get the provided commands.
     *
     * @return array<int, class-string>
     */
    public function provides(): array
    {
        return $this->commands;
    }
}
