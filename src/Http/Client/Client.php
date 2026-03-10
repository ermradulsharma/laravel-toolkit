<?php

namespace Skywalker\Support\Http\Client;

use Illuminate\Support\Facades\Http;

class Client
{
    /**
     * Create a new pending request instance.
     *
     * @return \Illuminate\Http\Client\PendingRequest
     */
    public static function create(): \Illuminate\Http\Client\PendingRequest
    {
        return Http::withHeaders([
            'User-Agent' => 'Skywalker/Support v1.0',
            'Accept' => 'application/json',
        ]);
    }

    /**
     * Proxy static method calls to Http facade.
     *
     * @param  string  $method
     * @param  array<int, mixed>  $parameters
     * @return mixed
     */
    public static function __callStatic(string $method, array $parameters)
    {
        return static::create()->$method(...$parameters);
    }
}
