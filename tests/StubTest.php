<?php

declare(strict_types=1);
namespace Skywalker\Support\Tests;

use Illuminate\Support\Str;
use Skywalker\Support\Filesystem\Stub;

class StubTest extends TestCase
{
    /** @var \Skywalker\Support\Filesystem\Stub */
    private $stub;

    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function tearDown(): void
    {
        unset($this->stub);

        parent::tearDown();
    }

    public function test_stub_is_instantiable(): void
    {
        $this->stub = new Stub(
            $file = $this->getFixturesPath('stubs/composer.stub')
        );

        static::assertInstanceOf(Stub::class, $this->stub);

        $fileContent = file_get_contents($file);

        static::assertEquals($fileContent, $this->stub->render());
        static::assertEquals($fileContent, (string) $this->stub);
    }

    public function test_it_can_create(): void
    {
        Stub::setBasePath(
            $basePath = $this->getFixturesPath('stubs')
        );

        $this->stub = Stub::create('composer.stub');

        $this->stub->replaces([
            'VENDOR' => 'skywalker',
            'PACKAGE' => 'package',
            'AUTHOR_NAME' => 'Skywalker Labs',
            'AUTHOR_EMAIL' => 'skywalkerlknw@gmail.com',
            'MODULE_NAMESPACE' => Str::studly('skywalker'),
            'STUDLY_NAME' => Str::studly('package'),
        ]);

        $this->stub->save('composer.json');

        $fixture = $this->getFixturesPath('stubs/composer.json');

        static::assertEquals(file_get_contents($fixture), $this->stub->render());

        $this->stub->saveTo($basePath, 'composer.json');

        static::assertEquals(file_get_contents($fixture), $this->stub->render());
    }

    public function test_it_can_set_and_get_base_path(): void
    {
        Stub::setBasePath(
            $basePath = $this->getFixturesPath('stubs')
        );

        static::assertEquals($basePath, Stub::getBasePath());
    }

    public function test_it_can_create_from_path(): void
    {
        $this->stub = Stub::createFromPath(
            $path = $this->getFixturesPath('stubs').'/composer.stub'
        );

        static::assertEmpty($this->stub->getBasePath());
        static::assertEquals($path, $this->stub->getPath());
        static::assertEmpty($this->stub->getReplaces());
    }
}
