<?php

namespace Skywalker\Support;

use Skywalker\Support\Providers\PackageServiceProvider;

/**
 * Class     ToolkitServiceProvider
 *
 * @author   Skywalker <skywalker@example.com>
 */
class ToolkitServiceProvider extends PackageServiceProvider
{
    /**
     * Vendor name.
     *
     * @var string
     */
    protected $vendor = 'skywalker-labs';

    /**
     * Package name.
     *
     * @var string
     */
    protected $package = 'toolkit';

    /**
     * Aliases.
     *
     * @var array<string, class-string>
     */
    protected $aliases = [
        'Health' => \Skywalker\Support\Support\Health::class,
    ];
}
