<?php

namespace Skywalker\Support\Routing\Concerns;

/**
 * Trait     RegistersRouteClasses
 *
 * @author   Skywalker <skywalker@example.com>
 */
trait RegistersRouteClasses
{
    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Map route classes.
     *
     * @param  iterable<int|string, string|object>  $routes
     */
    protected static function mapRouteClasses(iterable $routes): void
    {
        foreach ($routes as $route) {
            $routeString = is_object($route) ? get_class($route) : (string) $route;
            if (method_exists($routeString, 'map')) {
                app()->call("{$routeString}@map");
            }
        }
    }

    /**
     * Bind route classes.
     *
     * @param  iterable<int|string, string|object>  $routes
     */
    protected static function bindRouteClasses(iterable $routes): void
    {
        foreach ($routes as $route) {
            $routeString = is_object($route) ? get_class($route) : (string) $route;
            if (method_exists($routeString, 'bindings')) {
                app()->call("{$routeString}@bindings");
            }
        }
    }
}
