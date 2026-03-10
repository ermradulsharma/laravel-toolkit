<?php

declare(strict_types=1);

namespace Skywalker\Support\Tests\Providers;

use Skywalker\Support\Exceptions\PackageException;
use Skywalker\Support\Tests\Stubs\InvalidPackageServiceProvider;
use Skywalker\Support\Tests\Stubs\TestPackageServiceProvider;
use Skywalker\Support\Tests\TestCase;

class PackageServiceProviderTest extends TestCase
{
    /** @var \Skywalker\Support\Tests\Stubs\TestPackageServiceProvider */
    private $provider;

    protected function setUp(): void
    {
        parent::setUp();

        $this->provider = new TestPackageServiceProvider($this->app);

        $this->provider->register();
    }

    public function test_package_provider_is_instantiable(): void
    {
        $expectations = [
            \Illuminate\Support\ServiceProvider::class,
            \Skywalker\Support\Providers\ServiceProvider::class,
            \Skywalker\Support\Providers\PackageServiceProvider::class,
            \Skywalker\Support\Tests\Stubs\TestPackageServiceProvider::class,
        ];

        foreach ($expectations as $expected) {
            static::assertInstanceOf($expected, $this->provider);
        }
    }

    public function test_package_provider_can_register_config(): void
    {
        $config = config('package');

        static::assertArrayHasKey('foo', $config);
        static::assertEquals('bar', $config['foo']);
    }

    public function test_package_provider_must_throw_a_package_exception(): void
    {
        $this->expectException(PackageException::class);
        $this->expectExceptionMessage('You must specify the vendor/package name.');

        (new InvalidPackageServiceProvider($this->app))->register();
    }
}
