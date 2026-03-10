<?php

namespace Skywalker\Support\Validation\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class Slug implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  mixed  $value
     * @param  \Closure  $fail
     */
    public function validate(string $attribute, $value, Closure $fail): void
    {
        if (! is_string($value) || ! preg_match('/^[a-z0-9]+(::[a-z0-9]+)*$/', $value)) {
            $fail('The  must be a valid slug.');
        }
    }
}
