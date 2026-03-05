<?php

namespace Skywalker\Support\Providers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Str;
use ReflectionClass;
use Skywalker\Support\Exceptions\PackageException;
use Skywalker\Support\Http\BladeDirectives;
use Skywalker\Support\Providers\Concerns\HasAssets;
use Skywalker\Support\Providers\Concerns\HasConfig;
use Skywalker\Support\Providers\Concerns\HasFactories;
use Skywalker\Support\Providers\Concerns\HasMigrations;
use Skywalker\Support\Providers\Concerns\HasTranslations;
use Skywalker\Support\Providers\Concerns\HasViews;
use Skywalker\Support\Macros\CollectionMacros;
use Skywalker\Support\Macros\StringMacros;

/**
 * Class     PackageServiceProvider
 *
 * @author   Skywalker <skywalker@example.com>
 */
abstract class PackageServiceProvider extends ServiceProvider
{
    /* -----------------------------------------------------------------
     |  Traits
     | -----------------------------------------------------------------
     */

    use HasAssets,
        HasConfig,
        HasFactories,
        HasMigrations,
        HasTranslations,
        HasViews;

    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */

    /**
     * Vendor name.
     *
     * @var string
     */
    protected $vendor = 'skywalker-labs';

    /**
     * Package name.
     *
     * @var string|null
     */
    protected $package;

    /**
     * Package base path.
     *
     * @var string
     */
    protected $basePath;

    /* -----------------------------------------------------------------
     |  Constructor
     | -----------------------------------------------------------------
     */

    /**
     * Create a new service provider instance.
     */
    public function __construct(Application $app)
    {
        parent::__construct($app);

        if (is_null($this->basePath)) {
            $this->basePath = $this->resolveBasePath();
        }
    }

    /**
     * Resolve the base path of the package.
     *
     * @return string
     */
    protected function resolveBasePath()
    {
        return dirname(
            (new ReflectionClass($this))->getFileName(),
            2
        );
    }

    /* -----------------------------------------------------------------
     |  Getters & Setters
     | -----------------------------------------------------------------
     */

    /**
     * Get the base path of the package.
     *
     * @return string
     */
    public function getBasePath()
    {
        return $this->basePath;
    }

    /**
     * Get the vendor name.
     */
    protected function getVendorName()
    {
        return $this->vendor;
    }

    /**
     * Get the package name.
     */
    protected function getPackageName()
    {
        return $this->package;
    }

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Register the service provider.
     */
    public function register()
    {
        parent::register();

        $this->app->singleton(\Skywalker\Support\Security\ZeroTrust\TrustEngine::class, function ($app) {
            return new \Skywalker\Support\Security\ZeroTrust\TrustEngine;
        });

        $this->checkPackageName();
        $this->registerMacros();
        $this->registerCommands([
            \Skywalker\Support\Console\Commands\DiscoverProject::class,
            \Skywalker\Support\Console\Commands\MakeDto::class,
        ]);
    }

    /**
     * Boot the service provider.
     */
    public function boot()
    {
        $this->registerBladeDirectives();
    }

    /* -----------------------------------------------------------------
     |  Package Methods
     | -----------------------------------------------------------------
     */

    /**
     * Publish all the package files.
     */
    protected function publishAll()
    {
        $this->publishAssets();
        $this->publishConfig();
        $this->publishFactories();
        $this->publishMigrations();
        $this->publishTranslations();
        $this->publishViews();
    }

    /* -----------------------------------------------------------------
     |  Check Methods
     | -----------------------------------------------------------------
     */

    /**
     * Check package name.
     *
     * @throws \Skywalker\Support\Exceptions\PackageException
     */
    protected function checkPackageName()
    {
        if (empty($this->getVendorName()) || empty($this->getPackageName())) {
            throw PackageException::unspecifiedName();
        }
    }

    /* -----------------------------------------------------------------
     |  Other Methods
     | -----------------------------------------------------------------
     */

    /**
     * Get the published tags.
     */
    protected function getPublishedTags($tag)
    {
        $package = $this->getPackageName();

        return array_map(function ($name) {
            return Str::slug($name);
        }, [$this->getVendorName(), $package, $tag, $package.'-'.$tag]);
    }

    /**
     * Register the package macros.
     */
    protected function registerMacros()
    {
        CollectionMacros::register();
        StringMacros::register();
    }

    /**
     * Register the package blade directives.
     */
    protected function registerBladeDirectives()
    {
        BladeDirectives::register();
    }
}
