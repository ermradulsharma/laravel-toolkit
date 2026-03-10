<?php

declare(strict_types=1);

namespace Skywalker\Support\Tests;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Orchestra\Testbench\TestCase;
use Skywalker\Support\DataObjects\ValueObjects\Email;
use Skywalker\Support\Database\Concerns\HasUuid;
use Skywalker\Support\Database\Concerns\Sluggable;
use Skywalker\Support\Database\Repository\BaseRepository;

class FeatureExpansionTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Schema::create('test_models', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->json('settings')->nullable();
            $table->integer('price')->nullable();
            $table->timestamps();
        });
    }

    public function test_it_generates_uuid_and_slug(): void
    {
        $model = new TestModel;
        $model->title = 'Hello World';
        $model->save();

        $this->assertNotNull($model->id);
        $this->assertTrue(strlen($model->id) === 36);
        $this->assertEquals('hello-world', $model->slug);
    }

    public function test_it_casts_json(): void
    {
        $model = new TestModel;
        $model->settings = ['theme' => 'dark'];
        $model->save();

        $model->refresh();

        $this->assertIsArray($model->settings);
        $this->assertEquals('dark', $model->settings['theme']);
    }

    public function test_repo_can_create_and_find(): void
    {
        $repo = new TestRepository;
        $model = $repo->create(['title' => 'Repo Item']);

        $this->assertNotNull($model);
        $this->assertEquals('Repo Item', $model->title);

        $found = $repo->find($model->id);
        $this->assertEquals($model->id, $found->id);
    }

    public function test_value_object_validates_email(): void
    {
        $email = new Email('test@example.com');
        $this->assertEquals('test@example.com', (string) $email);

        $this->expectException(\InvalidArgumentException::class);
        new Email('invalid-email');
    }
}

class TestModel extends Model
{
    use HasUuid, Sluggable;

    protected $table = 'test_models';

    protected $guarded = [];

    public $timestamps = false; // simplify

    protected $casts = [
        'settings' => 'array',
    ];

    public function getSlugSource(): string
    {
        return 'title';
    }
}

class TestRepository extends BaseRepository
{
    public function model(): string
    {
        return TestModel::class;
    }
}
