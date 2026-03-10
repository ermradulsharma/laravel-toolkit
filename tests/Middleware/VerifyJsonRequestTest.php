<?php

declare(strict_types=1);

namespace Skywalker\Support\Tests\Middleware;

use Illuminate\Routing\Router;
use Skywalker\Support\Middleware\VerifyJsonRequest;
use Skywalker\Support\Tests\TestCase;

class VerifyJsonRequestTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->setupRoutes($this->app['router']);
    }

    public function test_it_can_get_json_response(): void
    {
        $this->json('GET', route('middleware::json.empty'))
            ->assertSuccessful()
            ->assertJson(['status' => 'success']);
    }

    public function test_it_can_pass_json_middleware(): void
    {
        foreach (['GET', 'POST', 'PUT', 'PATCH', 'DELETE'] as $method) {
            $this->json($method, route('middleware::json.param'))
                ->assertSuccessful()
                ->assertJson(['status' => 'success']);
        }
    }

    public function test_it_cannot_pass_json_middleware(): void
    {
        foreach (['GET', 'POST', 'PUT', 'PATCH', 'DELETE'] as $method) {
            $this->call($method, route('middleware::json.param'))
                ->assertStatus(400)
                ->assertJson([
                    'status' => 'error',
                    'code' => 400,
                    'message' => 'Request must be JSON',
                ]);
        }
    }

    private function setupRoutes(Router $router): void
    {
        $router->aliasMiddleware('json', VerifyJsonRequest::class);

        $router->prefix('json')->name('middleware::json.')->group(function (Router $router) {
            $router->get('/', function () {
                return response()->json(['status' => 'success']);
            })->name('empty')->middleware(['json']);

            foreach (['get', 'post', 'put', 'patch', 'delete'] as $method) {
                $router->{$method}('param', function () {
                    return response()->json(['status' => 'success']);
                })->name('param')->middleware(["json:{$method}"]);
            }
        });
    }
}
