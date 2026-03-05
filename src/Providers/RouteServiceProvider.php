<?php

namespace Skywalker\Support\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as IlluminateServiceProvider;
use Skywalker\Support\Routing\Concerns\RegistersRouteClasses;

/**
 * Class     RouteServiceProvider
 *
 * @author   Skywalker <skywalker@example.com>
 */
abstract class RouteServiceProvider extends IlluminateServiceProvider
{
    /* -----------------------------------------------------------------
     |  Traits
     | -----------------------------------------------------------------
     */

    use RegistersRouteClasses;
}
