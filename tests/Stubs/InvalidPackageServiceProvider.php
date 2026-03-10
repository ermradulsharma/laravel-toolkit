<?php

declare(strict_types=1);

namespace Skywalker\Support\Tests\Stubs;

use Skywalker\Support\Providers\PackageServiceProvider;

/**
 * Class     InvalidPackageServiceProvider
 *
 * @author   Skywalker <skywalker@example.com>
 */
class InvalidPackageServiceProvider extends PackageServiceProvider
{
    protected $vendor = '';

    protected $package = '';

    /**
     * Package base path.
     *
     * @var string
     */
    protected $basePath = __DIR__.'/..';
}
