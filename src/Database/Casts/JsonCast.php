<?php

namespace Skywalker\Support\Database\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class JsonCast implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  mixed  $value
     * @return array
     */
    public function get($model, string $key, $value, array $attributes)
    {
        return json_decode($value, true) ?: [];
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  mixed  $value
     * @return string
     */
    public function set($model, string $key, $value, array $attributes)
    {
        return json_encode($value);
    }
}
