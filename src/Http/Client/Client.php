<?php

namespace Skywalker\Support\Http\Client;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

class Client
{
    /**
     * Create a new pending request instance.
     */
    public static function create()
    {
        return Http::[
            'User-Agent' => 'Skywalker/Support v1.0',
            'Accept' => 'application/json',
        ]);
    }

    /**
     * Proxy static method calls to Http facade.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     */
    public static function __callStatic($method, $parameters)
    {
        return static::)->$method(...$parameters);
    }
}
