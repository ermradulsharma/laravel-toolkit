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
     */
    protected static function mapRouteClasses(iterable $routes)
    {
        foreach ($routes as $route) {
            if (method_exists($route, 'map')) {
                app()->call("{$route}@map");
            }
        }
    }

    /**
     * Bind route classes.
     */
    protected static function bindRouteClasses(iterable $routes)
    {
        foreach ($routes as $route) {
            if (method_exists($route, 'bindings')) {
                app()->call("{$route}@bindings");
            }
        }
    }
}
