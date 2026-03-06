<?php

namespace Skywalker\Support\Tests\Console\Commands;

use Illuminate\Support\Facades\File;
use Skywalker\Support\ToolkitServiceProvider;
use Skywalker\Support\Tests\TestCase;

class MakeDtoTest extends TestCase
{
    protected function getPackageProviders($app): array
    {
        return [
            ToolkitServiceProvider::class,
        ];
    }

    protected function setUp(): void
    {
        parent::setUp();
        
        // Clean up any generated DTOs
        if (File::isDirectory(app_path('Data/Dtos'))) {
            File::deleteDirectory(app_path('Data/Dtos'));
        }
    }

    public function test_it_can_create_a_dto_class(): void
    {
        $this->artisan('toolkit:dto', ['name' => 'UserDto'])
            ->expectsOutput('DTO [App\Data\Dtos\UserDto] created successfully.')
            ->assertExitCode(0);

        $this->assertTrue(File::exists(app_path('Data/Dtos/UserDto.php')));
        
        $content = File::get(app_path('Data/Dtos/UserDto.php'));
        $this->assertStringContainsString('namespace App\Data\Dtos;', $content);
        $this->assertStringContainsString('class UserDto extends Dto', $content);
    }

    public function test_it_can_create_a_dto_with_custom_namespace(): void
    {
        $this->artisan('toolkit:dto', ['name' => 'App\Support\Dtos\CustomDto'])
            ->expectsOutput('DTO [App\Support\Dtos\CustomDto] created successfully.')
            ->assertExitCode(0);

        $this->assertTrue(File::exists(app_path('Support/Dtos/CustomDto.php')));
    }

    public function test_it_does_not_overwrite_existing_dto_without_force(): void
    {
        $this->artisan('toolkit:dto', ['name' => 'ExistingDto'])->assertExitCode(0);
        
        $this->artisan('toolkit:dto', ['name' => 'ExistingDto'])
            ->expectsOutput('DTO [ExistingDto] already exists!')
            ->assertExitCode(1);
    }

    public function test_it_can_overwrite_existing_dto_with_force(): void
    {
        $this->artisan('toolkit:dto', ['name' => 'ForceDto'])->assertExitCode(0);
        
        $this->artisan('toolkit:dto', ['name' => 'ForceDto', '--force' => true])
            ->expectsOutput('DTO [App\Data\Dtos\ForceDto] created successfully.')
            ->assertExitCode(0);
    }
}
