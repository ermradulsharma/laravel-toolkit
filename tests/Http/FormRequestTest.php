<?php

declare(strict_types=1);
namespace Skywalker\Support\Tests\Http;

use Illuminate\Routing\Router;
use Skywalker\Support\Tests\Stubs\FormRequestController;
use Skywalker\Support\Tests\TestCase;

class FormRequestTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->setupRoutes($this->app['router']);
    }

    public function test_it_can_check_validation(): void
    {
        $this->post('form-request')
            ->assertStatus(302)
            ->assertRedirect('/');

        $response = $this->post('form-request', [
            'name' => 'Skywalker',
            'email' => 'skywalker@example.com',
        ]);

        $response
            ->assertSuccessful()
            ->assertJson([
                'name' => 'SKYWALKER',
                'email' => 'skywalker@example.com',
            ]);
    }

    public function test_it_can_sanitize(): void
    {
        $response = $this->post('form-request', [
            'name' => 'Skywalker',
            'email' => ' SKYWALKER@example.COM ',
        ]);

        $response
            ->assertSuccessful()
            ->assertJson([
                'name' => 'SKYWALKER',
                'email' => 'skywalker@example.com',
            ]);
    }

    private function setupRoutes(Router $router): void
    {
        $router->post('form-request', [FormRequestController::class, 'form'])
            ->name('form-request');
    }
}
