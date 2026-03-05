<?php

declare(strict_types=1);
namespace Skywalker\Support\Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;
use Skywalker\Support\Tests\Stubs\RouteServiceProviderWithRouteClasses;

/**
 * Class     TestCase
 *
 * @author   Skywalker <skywalker@example.com>
 */
abstract class TestCase extends BaseTestCase
{
    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Get package providers.
     *
     * @param  \Illuminate\Foundation\Application  $app
     */
    protected function getPackageProviders($app): array
    {
        return [
            // For Testing
            RouteServiceProviderWithRouteClasses::class,
        ];
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     */
    protected function getEnvironmentSetUp($app): void
    {
        //
    }

    /* -----------------------------------------------------------------
     |  Other Methods
     | -----------------------------------------------------------------
     */

    /**
     * Get fixture path
     */
    protected function getFixturesPath(string $path): string
    {
        return __DIR__.'/fixtures/'.$path;
    }
}
