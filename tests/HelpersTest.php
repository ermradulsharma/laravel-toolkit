<?php

declare(strict_types=1);
namespace Skywalker\Support\Tests;

use Illuminate\Contracts\Validation\Factory as ValidationFactory;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Filesystem\Filesystem;

class HelpersTest extends TestCase
{
    public function test_it_can_access_filesystem_via_helper(): void
    {
        $this->assertInstanceOf(Filesystem::class, filesystem());
    }

    public function test_it_can_access_validator_factory_via_helper(): void
    {
        $this->assertInstanceOf(ValidationFactory::class, validator());
    }

    public function test_it_can_create_validator_instance_via_helper(): void
    {
        $data = ['name' => 'John'];
        $rules = ['name' => 'required|string'];

        $validator = validator($data, $rules);

        $this->assertInstanceOf(Validator::class, $validator);
        $this->assertEquals($data, $validator->validate());
    }
}
