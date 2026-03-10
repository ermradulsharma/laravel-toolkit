<?php

namespace Skywalker\Support\Providers;

use Illuminate\Contracts\View\Factory as ViewFactory;

/**
 * Class     ViewComposerServiceProvider
 *
 * @author   Skywalker <skywalker@example.com>
 */
abstract class ViewComposerServiceProvider extends ServiceProvider
{
    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */

    /**
     * Register the composer classes.
     *
     * @var array<string, string|class-string>
     */
    protected $composerClasses = [
        // 'view-name' => 'class'
    ];

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Boot the view composer service provider.
     */
    public function boot(): void
    {
        $this->registerComposerClasses();
    }

    /**
     * Register the view composer classes.
     */
    protected function registerComposerClasses(): void
    {
        foreach ($this->composerClasses as $view => $class) {
            $this->composer($view, $class);
        }
    }

    /* -----------------------------------------------------------------
     |  Other Methods
     | -----------------------------------------------------------------
     */

    /**
     * Get the view factory instance.
     *
     * @return \Illuminate\Contracts\View\Factory
     */
    protected function view(): ViewFactory
    {
        return $this->app->make(ViewFactory::class);
    }

    /**
     * Register a view composer event.
     *
     * @param  array<int, string>|string  $views
     * @param  \Closure|string  $callback
     * @return array<int, mixed>
     */
    public function composer($views, $callback): array
    {
        return $this->view()->composer($views, $callback);
    }
}
