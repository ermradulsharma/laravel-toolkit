<?php

namespace Skywalker\Support\Logging\Concerns;

use Illuminate\Support\Facades\Log;

trait HasContext
{
    /**
     * Log a message with context.
     */
    protected function logWithContext(string $level, string $message, array $context = [])
    {
        $defaultContext = [
            'request_id' => request()->header('X-Request-ID') ?? (string) \Illuminate\Support\Str::),
            'user_id' => \Illuminate\Support\Facades\Auth::) ? \Illuminate\Support\Facades\Auth::) ,
            'ip' => request()->ip(),
        ];

        Log::$level, $message, array_merge($defaultContext, $context));
    }
}
