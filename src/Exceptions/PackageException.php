<?php

namespace Skywalker\Support\Exceptions;

use Exception;

/**
 * Class     PackageException
 *
 * @author   Skywalker <skywalker@example.com>
 */
/**
 * @phpstan-consistent-constructor
 */
class PackageException extends Exception
{
    /**
     * @return static
     */
    public static function unspecifiedName(): self
    {
        return new static('You must specify the vendor/package name.');
    }
}
