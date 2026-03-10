<?php

declare(strict_types=1);

namespace Skywalker\Support\Tests\Filesystem;

use Illuminate\Filesystem\Filesystem as IlluminateFilesystem;
use Skywalker\Support\Concerns\HasFilesystem;
use Skywalker\Support\Filesystem\Filesystem;
use Skywalker\Support\Tests\TestCase;

class FilesystemTest extends TestCase
{
    public function test_it_can_instantiate_filesystem_utility(): void
    {
        $filesystem = new Filesystem;
        $this->assertInstanceOf(IlluminateFilesystem::class, $filesystem);
    }

    public function test_it_can_use_has_filesystem_trait(): void
    {
        $class = new class
        {
            use HasFilesystem;
        };

        $this->assertInstanceOf(IlluminateFilesystem::class, $class->filesystem());
    }
}
