<?php

declare(strict_types=1);
namespace Skywalker\Support\Tests\Stubs;

use Skywalker\Support\Providers\PackageServiceProvider;

/**
 * Class     TestPackageServiceProvider
 *
 * @author   Skywalker <skywalker@example.com>
 */
class TestPackageServiceProvider extends PackageServiceProvider
{
    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */

    /**
     * Package name.
     *
     * @var string
     */
    protected $package = 'package';

    /**
     * Package base path.
     *
     * @var string
     */
    protected $basePath = __DIR__.'/..';

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Register the service provider.
     */
    public function register(): void
    {
        parent::register();

        $this->registerConfig();
    }

    /* -----------------------------------------------------------------
     |  Getters & Setters
     | -----------------------------------------------------------------
     */

    /**
     * Get config folder.
     */
    protected function getConfigFolder(): string
    {
        return realpath($this->getBasePath().DIRECTORY_SEPARATOR.'fixtures'.DIRECTORY_SEPARATOR.'config');
    }
}
