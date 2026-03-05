<?php

namespace Skywalker\Support\Routing;

use Illuminate\Contracts\Routing\Registrar;
use Illuminate\Routing\Router;
use Illuminate\Support\Traits\ForwardsCalls;
use Skywalker\Support\Routing\Concerns\RegistersRouteClasses;

/**
 * Class     RouteRegistrar
 *
 * @author   Skywalker <skywalker@example.com>
 *
 * @method \Illuminate\Routing\RouteRegistrar bind(string $key, \Closure $binder)
 * @method void map()
 * @method void bindings()
 *
 * @mixin  \Illuminate\Routing\RouteRegistrar
 */
abstract class RouteRegistrar
{
    /* -----------------------------------------------------------------
     |  Traits
     | -----------------------------------------------------------------
     */

    use ForwardsCalls,
        RegistersRouteClasses;

    /* -----------------------------------------------------------------
     |  Other Methods
     | -----------------------------------------------------------------
     */

    /**
     * Pass dynamic methods onto the router instance.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        return $this->forwardCallToRouter(
            app(Router::class),
            $method,
            $parameters
        );
    }

    /**
     * Pass dynamic methods onto the router instance.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     */
    protected function forwardCallToRouter(Registrar $router, $method, $parameters)
    {
        return $this->forwardCallTo($router, $method, $parameters);
    }
}
