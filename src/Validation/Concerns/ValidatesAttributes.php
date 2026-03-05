<?php

namespace Skywalker\Support\Validation\Concerns;

/**
 * Trait     ValidatesAttributes
 *
 * @author   Skywalker <skywalker@example.com>
 */
trait ValidatesAttributes
{
    /**
     * Validate the given data against the provided rules.
     *
     *
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function validate(array $data, array $rules, array $messages = [], array $customAttributes = [])
    {
        return validator($data, $rules, $messages, $customAttributes)->validate();
    }
}
