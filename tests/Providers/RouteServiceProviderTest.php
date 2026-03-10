<?php

declare(strict_types=1);

namespace Skywalker\Support\Tests\Providers;

use Skywalker\Support\Tests\TestCase;

class RouteServiceProviderTest extends TestCase
{
    public function test_it_can_map_routes(): void
    {
        $expectations = [
            'public::index' => $this->baseUrl,
            'public::contact.show' => $this->baseUrl.'/contact',
            'public::contact.post' => $this->baseUrl.'/contact',
            'public::contact.post' => $this->baseUrl.'/contact',
        ];

        foreach ($expectations as $route => $expected) {
            static::assertSame(route($route), $expected);
        }
    }

    public function test_it_can_bind_routes(): void
    {
        $content = $this->get(route('public::pages.show', ['page-1234']))
            ->assertSuccessful()
            ->getContent();

        static::assertEquals('1234', $content);
    }
}
