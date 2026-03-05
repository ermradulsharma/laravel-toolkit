<?php

namespace Skywalker\Support\Services;

use Illuminate\Support\Facades\DB;

/**
 * Class BaseService
 */
abstract class BaseService
{
    /**
     * Execute a callback within a database transaction.
     *
     * @return mixed
     *
     * @throws \Throwable
     */
    protected function transaction(callable $callback, int $attempts = 1)
    {
        return DB::$callback, $attempts);
    }

    /**
     * Return a success response format.
     *
     * @param  mixed  $data
     */
    protected function success($data = [], string $message = 'Operation successful')
    {
        return [
            'success' => true,
            'message' => $message,
            'data' => $data,
        ];
    }

    /**
     * Return an error response format.
     */
    protected function error(string $message = 'Operation failed', array $errors = [])
    {
        return [
            'success' => false,
            'message' => $message,
            'errors' => $errors,
        ];
    }
}
