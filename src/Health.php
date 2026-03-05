<?php

namespace Skywalker\Support;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class Health
{
    /**
     * Run a comprehensive health check.
     *
     * @return array
     */
    public static function check()
    {
        return [
            'status' => static::isHealthy() ? 'ok' : 'error',
            'checks' => [
                'database' => static::checkDatabase(),
                'storage' => static::checkStorage(),
                'env' => static::checkEnv(),
                'skywalker' => static::checkPackages(),
                'php_version' => PHP_VERSION,
            ],
            'timestamp' => \Illuminate\Support\Carbon::now()->toIso8601String(),
        ];
    }

    /**
     * Check if system is overall healthy.
     *
     * @return bool
     */
    public static function isHealthy()
    {
        return static::checkDatabase() && static::checkStorage();
    }

    /**
     * Check for installed Skywalker packages.
     *
     * @return array
     */
    protected static function checkPackages()
    {
        $packages = [
            'Location' => 'Skywalker\Location\LocationServiceProvider',
            'LogViewer' => 'Skywalker\LogViewer\LogViewerServiceProvider',
            'Entrust' => 'Skywalker\Entrust\EntrustServiceProvider',
        ];

        $status = [];
        foreach ($packages as $name => $class) {
            $status[$name] = class_exists($class) ? 'installed' : 'missing';
        }

        return $status;
    }

    /**
     * Check database connection.
     *
     * @return bool
     */
    protected static function checkDatabase()
    {
        try {
            DB::connection()->getPdo();

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Check storage permissions.
     *
     * @return bool
     */
    protected static function checkStorage()
    {
        return File::isWritable(storage_path());
    }

    /**
     * Check for required ENV keys.
     *
     * @return array
     */
    protected static function checkEnv()
    {
        $required = ['APP_KEY', 'DB_CONNECTION'];
        $missing = [];

        foreach ($required as $key) {
            if (empty(env($key))) {
                $missing[] = $key;
            }
        }

        return [
            'status' => empty($missing) ? 'ok' : 'warning',
            'missing' => $missing,
        ];
    }
}
