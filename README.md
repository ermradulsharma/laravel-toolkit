<div align="center">

# 🧱 Skywalker Toolkit
### *The Architectural Foundation for Elite Laravel Engineering*

[![Latest Version](https://img.shields.io/badge/version-1.3.0-darkgray.svg?style=for-the-badge)](https://packagist.org/packages/skywalker-labs/toolkit)
[![Laravel Version](https://img.shields.io/badge/Laravel-12.x-red.svg?style=for-the-badge)](https://laravel.com)
[![PHP Version](https://img.shields.io/badge/PHP-8.4+-777bb4.svg?style=for-the-badge)](https://php.net)
[![Pattern](https://img.shields.io/badge/Pattern-Clean_Architecture-blue.svg?style=for-the-badge)](https://github.com/skywalker-labs/toolkit)

---

**Skywalker Toolkit** is not just a utility package; it is a **Framework within a Framework**. It enforces strict **Consistency, Speed, and Security** across your entire Laravel ecosystem, eliminating the need to rewrite complex boilerplate code.

</div>

## 🏗️ The Core Pillars

### 1. Unified API Standard (`ApiResponse`)
Ensure every microservice speaks the same language. The `ApiResponse` trait provides standardized JSON structures for elite front-end consumption.

```php
use Skywalker\Support\Http\Concerns\ApiResponse;

class UserController extends Controller {
    use ApiResponse;

    public function show($id) {
        $user = User::find($id);
        return $this->apiSuccess($user, "User profile retrieved");
    }
}
```

**Available Methods:**
- `apiSuccess($data, $message, $code)`: Standard 200/Success response.
- `apiError($message, $code, $errors)`: Standard 400/Error response with error tracking.
- `apiCreated($data, $message)`: Optimized 201/Created response.
- `apiNoContent()`: Clean 204 response.

### 2. Prefixed Architecture (`PrefixedModel`)
Prevent database collision in multi-package environments. The `PrefixedModel` allows you to isolate table names dynamically.

```php
abstract class LocationModel extends PrefixedModel {
    protected $prefix = 'location_'; // Resulting table: location_locations
}
```

### 3. Advanced I/O & Profiling (`Command`)
Console commands designed for production. Integrated framing and structured output for professional DX.

```php
class SyncCommand extends \Skywalker\Support\Console\Command {
    public function handle(): int {
        $this->frame("Starting Elite Sync Process");
        // Your logic here
        return 0;
    }
}
```

### 4. Logic-Rich Traits & Utilities
From `Enum` support to sophisticated `Data Transfer Objects (DTO)`, Toolkit provides the tools to build immutable and predictable logic layers.

---

## 🛰️ Powering the Ecosystem

Toolkit forms the backbone of all Skywalker-Labs packages. It allows them to interact seamlessly without configuration bloat.

- 🏙️ **[skywalker-labs/location](https://github.com/skywalker-labs/location):** Uses `PrefixedModel` and `ApiResponse` for geoservice isolation.
- 📂 **[log-viewer](https://github.com/skywalker-labs/log-viewer):** Extends `ToolkitController` for standardized telemetry display.

---

## 🩺 Secret Feature: Integrated HealthCheck
Monitor your entire vault of Skywalker packages with a single call.

```php
use Skywalker\Support\Support\Health;

$status = Health::check();
// Returns deep-check of Database, Storage, and Skywalker Package Config (Location, Log-Viewer, Entrust)
```

---

## ⚡ Efficiency Benchmarks

| Activity | Standard Laravel | Skywalker Toolkit | Performance |
| :--- | :--- | :--- | :--- |
| **New Package Discovery** | 30 mins | **2 mins** | 15x Faster |
| **API Debugging** | High (Varied schema) | **Zero (Standardized)** | Elite DX |
| **Collision Risk** | High (Global namespace) | **Zero (Prefixed)** | Bulletproof |

---

Created & Maintained by **Skywalker-Labs**. The foundation for excellence.
