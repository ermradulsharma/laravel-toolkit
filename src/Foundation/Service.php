<?php

namespace Skywalker\Support\Foundation;

use Illuminate\Support\Facades\DB;

/**
 * Class Service
 */
abstract class Service
{
    /**
     * Execute a callback within a database transaction.
     *
     * @param  \Closure  $callback
     * @param  int  $attempts
     * @return mixed
     *
     * @throws \Throwable
     */
    protected function transaction(\Closure $callback, int $attempts = 1)
    {
        return DB::transaction($callback, $attempts);
    }

    /**
     * Return a success response format.
     *
     * @param  mixed  $data
     * @param  string  $message
     * @return array<string, mixed>
     */
    protected function success($data = [], string $message = 'Operation successful'): array
    {
        return [
            'success' => true,
            'message' => $message,
            'data' => $data,
        ];
    }

    /**
     * Return an error response format.
     *
     * @param  string  $message
     * @param  array<string, mixed>  $errors
     * @return array<string, mixed>
     */
    protected function error(string $message = 'Operation failed', array $errors = []): array
    {
        return [
            'success' => false,
            'message' => $message,
            'errors' => $errors,
        ];
    }
}
