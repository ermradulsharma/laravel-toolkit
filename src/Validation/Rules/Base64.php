<?php

namespace Skywalker\Support\Validation\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class Base64 implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  mixed  $value
     * @param  \Closure  $fail
     */
    public function validate(string $attribute, $value, Closure $fail): void
    {
        if (! is_string($value) || ! preg_match('/^[a-zA-Z0-9\/\r\n+]*={0,2}$/', $value)) {
            $fail('The  must be a valid base64 encoded string.');
        }
    }
}
