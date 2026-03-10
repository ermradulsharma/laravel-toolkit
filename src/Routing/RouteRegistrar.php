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
     |  Properties
     | -----------------------------------------------------------------
     */

    /**
     * The router instance.
     *
     * @var \Illuminate\Contracts\Routing\Registrar
     */
    protected Registrar $router;

    /* -----------------------------------------------------------------
     |  Constructor
     | -----------------------------------------------------------------
     */

    /**
     * Create a new RouteRegistrar instance.
     *
     * @param  \Illuminate\Contracts\Routing\Registrar  $router
     * @return void
     */
    public function __construct(Registrar $router)
    {
        $this->router = $router;
    }

    /* -----------------------------------------------------------------
     |  Other Methods
     | -----------------------------------------------------------------
     */

    /**
     * Handle dynamic method calls.
     *
     * @param  string  $method
     * @param  array<int, mixed>  $parameters
     * @return mixed
     */
    public function __call(string $method, array $parameters): mixed
    {
        return $this->forwardCallToRouter($method, $parameters);
    }

    /**
     * Forward the call to the router.
     *
     * @param  string  $method
     * @param  array<int, mixed>  $parameters
     * @return mixed
     */
    protected function forwardCallToRouter(string $method, array $parameters): mixed
    {
        return $this->router->{$method}(...$parameters);
    }
}
