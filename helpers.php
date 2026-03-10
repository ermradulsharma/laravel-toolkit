<?php

if (! function_exists('laravel_version')) {
    /**
     * Get laravel version or check if the same version
     *
     * @param  string|null  $version
     * @return string|bool
     */
    function laravel_version($version = null)
    {
        $appVersion = app()->version();

        if (is_null($version)) {
            return $appVersion;
        }

        return substr($appVersion, 0, strlen($version)) === $version;
    }
}

if (! function_exists('route_is')) {
    /**
     * Check if route(s) is the current route.
     *
     * @param  array|string  $routes
     * @return bool
     */
    function route_is($routes)
    {
        if (! is_array($routes)) {
            $routes = [$routes];
        }

        /** @var \Illuminate\Routing\Router $router */
        $router = app('router');

        return call_user_func_array([$router, 'is'], $routes);
    }
}

if (! function_exists('filesystem')) {
    /**
     * Get the filesystem instance.
     *
     * @return \Illuminate\Filesystem\Filesystem
     */
    function filesystem()
    {
        return app('files');
    }
}

if (! function_exists('validator')) {
    /**
     * Create a new Validator instance.
     *
     * @return \Illuminate\Contracts\Validation\Validator|\Illuminate\Contracts\Validation\Factory
     */
    function validator(array $data = [], array $rules = [], array $messages = [], array $customAttributes = [])
    {
        $factory = app(\Illuminate\Contracts\Validation\Factory::class);

        if (func_num_args() === 0) {
            return $factory;
        }

        return $factory->make($data, $rules, $messages, $customAttributes);
    }
}
