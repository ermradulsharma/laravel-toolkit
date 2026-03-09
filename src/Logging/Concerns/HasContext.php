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
            'request_id' => request()->header('X-Request-ID') ?? (string) \Illuminate\Support\Str::uuid(),
            'user_id' => \Illuminate\Support\Facades\Auth::id() ? \Illuminate\Support\Facades\Auth::id() : null,
            'ip' => request()->ip(),
        ];

        Log::$level($message, array_merge($defaultContext, $context));
    }
}
