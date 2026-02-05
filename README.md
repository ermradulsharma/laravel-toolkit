# Laravel Toolkit

[![Packagist License](https://img.shields.io/packagist/l/ermradulsharma/laravel-toolkit.svg?style=flat-square)](LICENSE.md)
[![Latest Version on Packagist](https://img.shields.io/packagist/v/ermradulsharma/laravel-toolkit.svg?style=flat-square)](https://packagist.org/packages/ermradulsharma/laravel-toolkit)
[![Total Downloads](https://img.shields.io/packagist/dt/ermradulsharma/laravel-toolkit.svg?style=flat-square)](https://packagist.org/packages/ermradulsharma/laravel-toolkit)

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
  - [Productivity Macros](#productivity-macros)
  - [Enum Helpers](#enum-helpers)
  - [Blade Directives](#blade-directives)
  - [Logging & Console Tools](#logging--console-tools)
- [Testing](#testing)
- [Security](#security)
- [License](#license)

---

## Features

- **Standardized Infrastructure**: robust base classes for Service Providers, Migrations, and Seeders.
- **Resource Management**: Automated handling of views, configs, translations, and assets.
- **Modern API Tools**: Standardized JSON responses and typed DTOs.
- **Enhanced Validation**: Ready-to-use rules for passwords, slugs, base64, and colors.
- **Developer Productivity**: Handy macros for Collections/Strings and Enum helpers.
- **Blade Extensions**: Directives for active states, money formatting, and dates.

---

## Installation

```bash
composer require ermradulsharma/laravel-toolkit
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
class User extends PrefixedModel {
    protected $prefix = 'app_';
}
```

#### Base Migration & Seeder

Standardize your database logic with our base classes.

```php
class CreateUsersTable extends \Skywalker\Support\Database\Migration {
    public function up(): void {
        $this->createSchema(function (Blueprint $table) {
            $table->id();
            $table->string('name');
        });
    }
}
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

### Productivity Macros

#### Collections

- `toKebabCase()`: Recursively transform array keys to kebab-case.
- `toCamelCase()`: Recursively transform array keys to camelCase.

#### Strings

- `Str::isBase64($string)`: Validate base64 format quickly.

### Enum Helpers

Utilities for PHP 8.1+ Enums.

```php
use Skywalker\Support\Support\Enums;

Enums::values(MyEnum::class); // [1, 2, 3]
Enums::names(MyEnum::class);  // ['PENDING', 'ACTIVE', 'DELETED']
Enums::options(MyEnum::class); // Used for select dropdowns
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

If you discover any security related issues, please email <skywalker@example.com> instead of using the issue tracker.

---

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
