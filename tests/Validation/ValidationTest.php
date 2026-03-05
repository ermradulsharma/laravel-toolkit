<?php

declare(strict_types=1);
namespace Skywalker\Support\Tests\Validation;

use Illuminate\Contracts\Validation\Factory as ValidationFactory;
use Illuminate\Validation\ValidationException;
use Skywalker\Support\Concerns\HasValidator;
use Skywalker\Support\Tests\TestCase;
use Skywalker\Support\Validation\Concerns\ValidatesAttributes;

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

    public function test_it_can_use_validates_attributes_trait(): void
    {
        $class = new class
        {
            use ValidatesAttributes;
        };

        $data = ['name' => 'John'];
        $rules = ['name' => 'required'];

        $validated = $class->validate($data, $rules);

        $this->assertEquals($data, $validated);
    }

    public function test_it_throws_exception_on_vaildation_failure(): void
    {
        $this->expectException(ValidationException::class);

        $class = new class
        {
            use ValidatesAttributes;
        };

        $class->validate([], ['name' => 'required']);
    }
}
