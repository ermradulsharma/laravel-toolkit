<?php

namespace Skywalker\Support\Concerns;

use Illuminate\Filesystem\Filesystem;

/**
 * Trait     HasFilesystem
 *
 * @author   Skywalker <skywalker@example.com>
 */
trait HasFilesystem
{
    /**
     * Get the filesystem instance.
     */
    public function filesystem()
    {
        return filesystem();
    }
}
