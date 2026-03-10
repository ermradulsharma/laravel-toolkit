<?php

namespace Skywalker\Support\Providers\Concerns;

/**
 * Trait     InteractsWithApplication
 *
 * @author   Skywalker <skywalker@example.com>
 */
trait InteractsWithApplication
{
    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Register multiple service providers.
     *
     * @param  array<int, class-string<\Illuminate\Support\ServiceProvider>|\Illuminate\Support\ServiceProvider>  $providers
     */
    protected function registerProviders(array $providers): void
    {
        foreach ($providers as $provider) {
            $this->registerProvider($provider);
        }
    }

    /**
     * Register a service provider.
     *
     * @param  \Illuminate\Support\ServiceProvider|class-string<\Illuminate\Support\ServiceProvider>  $provider
     * @param  bool  $force
     * @return \Illuminate\Support\ServiceProvider
     */
    protected function registerProvider($provider, bool $force = false): \Illuminate\Support\ServiceProvider
    {
        return $this->app->register($provider, $force);
    }

    /**
     * Register a console service provider.
     *
     * @param  \Illuminate\Support\ServiceProvider|class-string<\Illuminate\Support\ServiceProvider>  $provider
     * @param  bool  $force
     * @return \Illuminate\Support\ServiceProvider|null
     */
    protected function registerConsoleServiceProvider($provider, bool $force = false): ?\Illuminate\Support\ServiceProvider
    {
        if ($this->app->runningInConsole()) {
            return $this->registerProvider($provider, $force);
        }

        return null;
    }

    /**
     * Register the package's custom Artisan commands when running in console.
     *
     * @param  array<int, class-string<\Illuminate\Console\Command>|string>  $commands
     */
    protected function registerCommands(array $commands): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands($commands);
        }
    }

    /**
     * Register a binding with the container.
     *
     * @param  string  $abstract
     * @param  \Closure|string|null  $concrete
     * @param  bool  $shared
     */
    protected function bind(string $abstract, $concrete = null, bool $shared = false): void
    {
        $this->app->bind($abstract, $concrete, $shared);
    }

    /**
     * Register a shared binding in the container.
     *
     * @param  string  $abstract
     * @param  \Closure|string|null  $concrete
     */
    protected function singleton(string $abstract, $concrete = null): void
    {
        $this->app->singleton($abstract, $concrete);
    }
}
