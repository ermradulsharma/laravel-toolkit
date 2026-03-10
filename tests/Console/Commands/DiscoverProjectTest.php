<?php

namespace Skywalker\Support\Tests\Console\Commands;

use Illuminate\Support\Facades\File;
use Skywalker\Support\Tests\TestCase;
use Skywalker\Support\ToolkitServiceProvider;

class DiscoverProjectTest extends TestCase
{
    protected function getPackageProviders($app): array
    {
        return [
            ToolkitServiceProvider::class,
        ];
    }

    public function test_it_can_generate_project_map(): void
    {
        $outputPath = 'test-map.json';

        if (File::exists(base_path($outputPath))) {
            File::delete(base_path($outputPath));
        }

        $this->artisan('toolkit:discover', ['--output' => $outputPath])
            ->expectsOutput('Scanning project structure...')
            ->expectsOutput("Project map generated successfully at: {$outputPath}")
            ->assertExitCode(0);

        $this->assertTrue(File::exists(base_path($outputPath)));

        $content = json_decode(File::get(base_path($outputPath)), true);
        $this->assertArrayHasKey('routes', $content);
        $this->assertArrayHasKey('models', $content);
        $this->assertArrayHasKey('actions', $content);
        $this->assertArrayHasKey('config', $content);

        File::delete(base_path($outputPath));
    }
}
