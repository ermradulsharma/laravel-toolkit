<?php

namespace Skywalker\Support\Providers;

use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;
use Skywalker\Support\Providers\Concerns\InteractsWithApplication;

/**
 * Class     ServiceProvider
 *
 * @author   Skywalker <skywalker@example.com>
 */
abstract class ServiceProvider extends IlluminateServiceProvider
{
    /* -----------------------------------------------------------------
     |  Traits
     | -----------------------------------------------------------------
     */

    use InteractsWithApplication;
}
