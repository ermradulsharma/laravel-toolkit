<?php

declare(strict_types=1);
namespace Skywalker\Support\Tests\Http;

use Illuminate\Routing\Router;
use Skywalker\Support\Tests\Stubs\DummyController;
use Skywalker\Support\Tests\TestCase;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->setupRoutes($this->app['router']);
    }

    public function test_it_can_do_dummy_stuff(): void
    {
        $response = $this->get(route('dummy::index'))
            ->assertSuccessful();

        static::assertEquals('Dummy', $response->getContent());

        $response = $this->get(route('dummy::get', ['super']))
            ->assertSuccessful();

        static::assertEquals('Super dummy', $response->getContent());
    }

    public function test_it_can_throw_four_o_four_exception(): void
    {
        $response = $this->get(route('dummy::get', ['not-super']))
            ->assertStatus(404);

        static::assertInstanceOf(NotFoundHttpException::class, $response->exception);
        static::assertSame('Super dummy not found !', $response->exception->getMessage());
    }

    protected function setupRoutes(Router $router): void
    {
        $router->get('dummy', [DummyController::class, 'index'])
            ->name('dummy::index');

        $router->get('dummy/{slug}', [DummyController::class, 'show'])
            ->name('dummy::get');
    }
}
