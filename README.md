<p align="center">
  <img src="laravel_toolkit.png" alt="Laravel Toolkit" height="450" style="width: 100%;">
</p>

# Laravel Toolkit

[![Packagist License](https://img.shields.io/packagist/l/skywalker/support.svg?style=flat-square)](LICENSE.md)
[![Latest Version on Packagist](https://img.shields.io/packagist/v/skywalker/support.svg?style=flat-square)](https://packagist.org/packages/skywalker/support)
[![Total Downloads](https://img.shields.io/packagist/dt/skywalker/support.svg?style=flat-square)](https://packagist.org/packages/skywalker/support)

**Laravel Toolkit** is an essential collection of helpers, base classes, and infrastructure tools designed to streamline Laravel package and application development.

## Table of Contents

- [Features](#features)
- [Installation](#installation)
- [Usage](#usage)
  - [Package Service Provider](#package-service-provider)
  - [Core Infrastructure Traits](#core-infrastructure-traits)
  - [Database Utilities](#database-utilities)
  - [API Utilities](#api-utilities)
  - [Data Transfer Objects (DTOs)](#data-transfer-objects-dtos)
  - [Enhanced Validation](#enhanced-validation)
  - [System Health Checks](#system-health-checks)
  - [Stub Generation](#stub-generation)
  - [Global Helpers](#global-helpers)
  - [Productivity Macros](#productivity-macros)
  - [Enum Helpers](#enum-helpers)
  - [Blade Directives](#blade-directives)
  - [Logging & Console Tools](#logging--console-tools)
  - [AI-Ready Tools](#ai-ready-tools)
- [Testing](#testing)
- [Security](#security)
- [License](#license)

---

## Features

- **Standardized Infrastructure**: Robust base classes for Service Providers, Migrations, and Seeders.
- **Resource Management**: Automated handling of views, configs, translations, and assets.
- **Modern API Tools**: Standardized JSON responses and typed DTOs.
- **Enhanced Validation**: Ready-to-use rules for passwords, slugs, base64, and colors.
- **System Health**: Built-in health checks for database, storage, and environment.
- **Code Generation**: Fluent Stub engine for generating files.
- **Developer Productivity**: Handy macros, global helpers, and Enum utilities.
- **Blade Extensions**: Directives for active states, money formatting, and dates.

---

## Installation

```bash
composer require skywalker/support
```

---

## Usage

### Package Service Provider

The `PackageServiceProvider` is the foundation of your package. It automates resource registration via powerful traits.

```php
use Skywalker\Support\Providers\PackageServiceProvider;

class MyServiceProvider extends PackageServiceProvider
{
    protected $vendor = 'my-vendor';
    protected $package = 'my-package';

    public function boot()
    {
        parent::boot(); // Handles Blade directives & other auto-registrations

        $this->publishAll(); // Publishes config, views, migrations, etc.
    }
}
```

### Core Infrastructure Traits

Included in the `PackageServiceProvider` to manage your package assets:

- `HasConfig`: Manage single or multiple configuration files (`$multiConfigs = true`).
- `HasViews`: Automatic directory-based view loading.
- `HasMigrations`: Easy migration registration.
- `HasTranslations`: Language file management.
- `HasAssets`: Manage and publish public assets.
- `HasFactories`: Automated model factory discovery.

### Database Utilities

#### Prefixed Model

Extend `PrefixedModel` to easily manage table prefixes at the model level.

```php
use Skywalker\Support\Database\PrefixedModel;

class User extends PrefixedModel {
    protected $prefix = 'app_';
}
```

#### Base Migration & Seeder

Standardize your database logic with our base classes.

```php
use Skywalker\Support\Database\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {
    public function up(): void {
        $this->createSchema(function (Blueprint $table) {
            $table->id();
            $table->string('name');
        });
    }
}
```

#### Repository Pattern

Abstract your database logic using the `BaseRepository`.

```php
use App\Models\User;
use Skywalker\Support\Database\Repository\BaseRepository;

class UserRepository extends BaseRepository {
    public function model(): string {
        return User::class;
    }
}

// Usage
$repo = new UserRepository();
$users = $repo->all();
$user = $repo->create(['name' => 'Luke']);
```

#### Service Pattern

Encapsulate your business logic with transaction support.

```php
use Skywalker\Support\Support\Services\BaseService;

class OrderService extends BaseService {
    public function placeOrder(array $data) {
        return $this->transaction(function() use ($data) {
            // ... logic
            return $this->success([], 'Order placed');
        });
    }
}
```

#### Custom Casts

**JsonCast**

Cast JSON data to array/object.

```php
use Skywalker\Support\Database\Casts\JsonCast;

class User extends Model {
    protected $casts = ['settings' => JsonCast::class];
}
```

**MoneyCast**

Cast integer (cents) to float.

```php
class Product extends Model {
    protected $casts = ['price' => MoneyCast::class];
}
```

#### Service Pattern

Encapsulate your business logic with transaction support.

```php
use Skywalker\Support\Support\Services\BaseService;

class OrderService extends BaseService {
    public function placeOrder(array $data) {
        return $this->transaction(function() use ($data) {
            // ... logic
            return $this->success([], 'Order placed');
        });
    }
}
```

#### Custom Casts

**JsonCast**

Cast JSON data to array/object.

```php
use Skywalker\Support\Database\Casts\JsonCast;

class User extends Model {
    protected $casts = ['settings' => JsonCast::class];
}
```

**MoneyCast**

Cast integer (cents) to float.

```php
class Product extends Model {
    protected $casts = ['price' => MoneyCast::class];
}
```

#### Model Traits

**HasUuid**

Automatically generate UUIDs for your models.

```php
use Skywalker\Support\Database\Concerns\HasUuid;

class Transaction extends Model {
    use HasUuid;
}
```

**Sluggable**

Automatically generate slugs from a source column.

```php
use Skywalker\Support\Database\Concerns\Sluggable;

class Post extends Model {
    use Sluggable;

    public function getSlugSource(): string {
        return 'title';
    }
}
```

### Http Client

A wrapper around Laravel's Http client with standardized headers.

```php
use Skywalker\Support\Http\Client\Client;

$response = Client::get('https://api.example.com');
```

### API Utilities

Standardize your API layer with the `ApiResponse` trait.

```php
use Skywalker\Support\Http\Concerns\ApiResponse;

class UserController extends Controller
{
    use ApiResponse;

    public function show($user)
    {
        return $this->apiSuccess($user, 'User found');
    }

    public function error()
    {
        return $this->apiError('Something went wrong', 400);
    }
}
```

### Data Transfer Objects (DTOs)

Cleanly move data between layers with typed objects.

```php
use Skywalker\Support\Data\Dto;

class UserDto extends Dto
{
    public string $name;
    public int $age;
}

$dto = UserDto::fromArray(['name' => 'Alice', 'age' => 25]);
```

### Value Objects

Encapsulate validation and formatting with `ValueObject`.

```php
use Skywalker\Support\Data\ValueObjects\Email;

$email = new Email('skywalker@example.com');
echo $email; // skywalker@example.com
```

### Enhanced Validation

```php
use Skywalker\Support\Validation\Rules\{StrongPassword, Slug, HexColor, Base64};

$rules = [
    'password' => [new StrongPassword],
    'handle'   => [new Slug],
    'theme'    => [new HexColor],
    'avatar'   => [new Base64],
];
```

### System Health Checks

Perform comprehensive checks on your application's vital services.

```php
use Skywalker\Support\Support\Health;

// Quick check (returns bool)
if (Health::isHealthy()) {
    // Database and Storage are accessible
}

// Full diagnostic report
$report = Health::check();
/*
[
    'status' => 'ok', // or 'error'
    'checks' => [
        'database' => true,
        'storage' => true,
        'env' => ['status' => 'ok', 'missing' => []],
        'php_version' => '8.2.0',
    ],
    'timestamp' => '...'
]
*/
```

### Stub Generation

The `Stub` class provides a fluent interface for generating files from templates.

```php
use Skywalker\Support\Stub;

// Create from a template file
$stub = Stub::createFromPath(__DIR__ . '/stubs/controller.stub', [
    'NAMESPACE' => 'App\Http\Controllers',
    'CLASS'     => 'UserController',
]);

// Save to destination
$stub->saveTo(app_path('Http/Controllers'), 'UserController.php');

// Or get content directly
echo $stub->render();
```

#### DTO Generator

Generate DTOs quickly via Artisan.

```bash
php artisan toolkit:make-dto UserDto
```

### Global Helpers

Convenient global functions available throughout your application.

```php
// Check if current route(s) match
if (route_is('admin.*')) {
    // ...
}

// Check or get Laravel version
if (laravel_version('11.0')) {
    // Running on Laravel 11.x
}
```

### Productivity Macros

#### Collections

- `toKebabCase()`: Recursively transform array keys to kebab-case.
- `toCamelCase()`: Recursively transform array keys to camelCase.

#### Strings

- `Str::isBase64($string)`: Validate base64 format quickly.

### Enum Helpers

Utilities for PHP 8.1+ Enums using the `Enum` trait.

```php
use Skywalker\Support\Support\Concerns\Enum;

enum Status: string {
    use Enum;
    
    case PENDING = 'pending';
    case ACTIVE = 'active';
}

Status::values(); // ['pending', 'active']
Status::options(); // ['pending' => 'PENDING', 'active' => 'ACTIVE']
```

### Blade Directives

```blade
@active('home') {{-- outputs "active" if route is current --}}
@money(2500, 'INR') {{-- 2,500.00 INR --}}
@date($user->created_at, 'd M Y') {{-- formatted date --}}
```

### Logging & Console Tools

- **HasContext**: Trait for logging with automatic request/user metadata.
- **InteractsWithIO**: Trait for beautiful Artisan output (`successBox`, `errorBox`, `infoBox`).

### AI-Ready Tools

Specifically designed to optimize the developer-AI collaboration.

#### Project Discovery

Generate a comprehensive map of your project structure for AI context:

```bash
php artisan toolkit:discover
```

#### Action Pattern

Enforce Single Responsibility for easier AI refactoring:

```php
use Skywalker\Support\Actions\Action;

class CreateUserAction extends Action {
    public function execute(...$args) {
        // ... business logic
    }
}
```

#### DTO JSON Schemas

Share data structures with AI assistants:

```php
$schema = UserDto::toJsonSchema();
```

---

## Testing

```bash
composer test
```

---

## Security

If you discover any security related issues, please email <skywalkerlknw@gmail.com> instead of using the issue tracker.

---

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
