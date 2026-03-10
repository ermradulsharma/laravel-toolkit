<?php

namespace Skywalker\Support\DataObjects\ValueObjects;

use InvalidArgumentException;
use Skywalker\Support\Foundation\ValueObject;

class Email extends ValueObject
{
    /**
     * The email address.
     *
     * @var string
     */
    protected $email;

    /**
     * Create a new Email instance.
     *
     * @throws \InvalidArgumentException
     */
    public function __construct(string $email)
    {
        if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException("Invalid email address: {$email}");
        }

        $this->email = $email;
    }

    /**
     * Return string representation.
     */
    public function __toString(): string
    {
        return $this->email;
    }
}
