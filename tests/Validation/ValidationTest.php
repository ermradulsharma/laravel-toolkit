<?php

declare(strict_types=1);

namespace Skywalker\Support\Tests\Validation;

use Illuminate\Contracts\Validation\Factory as ValidationFactory;
use Illuminate\Validation\ValidationException;
use Skywalker\Support\Concerns\HasValidator;
use Skywalker\Support\Tests\TestCase;

class ValidationTest extends TestCase
{
    public function test_it_can_use_has_validator_trait(): void
    {
        $class = new class
        {
            use HasValidator;
        };

        $this->assertInstanceOf(ValidationFactory::class, $class->validator());
    }
}
