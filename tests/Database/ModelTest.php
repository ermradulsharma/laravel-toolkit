<?php

declare(strict_types=1);

namespace Skywalker\Support\Tests\Database;

use Skywalker\Support\Tests\TestCase;

class ModelTest extends TestCase
{
    /** @var \Skywalker\Support\Database\PrefixedModel */
    protected $model;

    protected function setUp(): void
    {
        parent::setUp();

        $this->model = new \Skywalker\Support\Tests\Stubs\Models\Product;
    }

    protected function tearDown(): void
    {
        unset($this->model);

        parent::tearDown();
    }

    public function test_database_model_is_instantiable(): void
    {
        $expectations = [
            \Illuminate\Database\Eloquent\Model::class,
            \Skywalker\Support\Database\PrefixedModel::class,
        ];

        foreach ($expectations as $expected) {
            static::assertInstanceOf($expected, $this->model);
        }
    }

    public function test_it_can_get_table_name_without_prefix(): void
    {
        static::assertSame('products', $this->model->getTable());
    }

    public function test_it_can_set_and_get_prefix(): void
    {
        $this->model->setPrefix($prefix = 'shop_');

        static::assertSame($prefix, $this->model->getPrefix());
        static::assertSame($prefix.'products', $this->model->getTable());
    }
}
