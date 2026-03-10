All notable changes to `skywalker-labs/toolkit` will be documented in this file.

## [1.5.0] - 2026-03-10

### 🚀 Added
- **Aether Clean Architecture:** Migrated core classes to the `Foundation` namespace (`Dto`, `Service`, `Action`, `ValueObject`).
- **JSON Schema Generation:** Integrated automatic JSON schema induction for DTOs to streamline API documentation.
- **Route Registrar:** Introduced specialized `RouteRegistrar` for class-based, modular routing strategies.
- **Elite Documentation Suite:** Added `MAINTAINERS.md`, and full GitHub community templates (Issue/PR).

### 🛡️ Security & Hardening
- **Vulnerability Patch:** Updated `league/commonmark` to v2.8.1 to mitigate cross-site scripting (XSS) bypass risks.
- **XSS Protection:** Hardened all custom Blade directives (`@active`, `@money`, `@date`) with automatic HTML escaping (`e()` helper).
- **Secure Data Layer:** Verified 100% usage of prepared statements across all core repository patterns.

### 🛠️ Changed
- **PHP 7.4+ Compatibility:** Standardized syntax (reverted `match` to `switch`, removed `: mixed`) to ensure deterministic performance across PHP 7.4-8.4.
- **Professional Composer:** Standardized `composer.json` with elite metadata, optimized scripts (`@all`, `@test-coverage`), and modern configuration.
- **CI/CD Reliability:** Enforced in-memory SQLite testing to eliminate environmental file dependencies and ensure 100% green builds.

### 🧹 Removed
- **Unused & Unusual Code:** Purged 15+ redundant or speculative files, empty architectural folders, and legacy traits (`ApiResponse`, `ChainedAuditTrait`, `JsonCast`, etc.).
- **Zero Errors:** Achieved literal **zero PHPStan Level 9 errors** and **100% test success** (34 tests, 102 assertions).


## [1.4.0] - 2026-03-05

### Added
- Absolute multi-version compatibility (PHP `^7.0|^8.0|^9.0` & Laravel `^5.5` to `^12.0`).
- Global `filesystem()` and `validator()` helpers.
- Automated `ToolkitServiceProvider` for Laravel ecosystem auto-discovery.
- Robust, flattened `src/` directory separating Concerns, Database, Validation, Http, and Routing dynamically.

## 🛡️ Developmental Standards
The primary purpose of **Skywalker Toolkit** is to be an indestructible baseline for packages. 

**STRICT COMPATIBILITY GUIDELINES**:
- Target **PHP 7.4+** for core maturity (allows for scalar typing and return types).
- Maintain support for Laravel **^6.20.45** through **^12.x**.
- **Dropped Laravel 5.5** due to permanent unpatchable security vulnerabilities (CVE-2024-52301).
- **PHPStan Level 9** is the mandatory baseline for all new components.
- Do **not** use match expressions, named arguments, or property promotion if you aim for PHP < 8.0 support.

### Changed
- **Major Architecture Refactor:** Purged modern strict types (`declare(strict_types=1);`), union types, and forced return types across the entire package to ensure flawless compatibility with PHP 7.0.
- Relocated Base configuration to root `config/toolkit.php`.
- Centralized `Stub` operations into the `Filesystem` namespace.
- Hardened reflection parsing during testing environments for seamless Provider boot cycles.

### Fixed
- Fixed regex-induced syntax corruption in `PrefixedModel`, `VerifyJsonRequest`, `Health`, `TrustEngine`, and multiple `Concerns`.
- Fixed array parsing logic in `Enum` trait utility.
- Resolved collision vulnerabilities in `CollectionMacros` and `StringMacros` by making registration strictly idempotent.

## [1.0.0] - 2026-02-06

### Added
- Initial release of the rebranded **Laravel Toolkit**.
- API Utilities (`ApiResponse` trait).
- Data Transfer Objects (DTOs) base class.
- Enhanced Validation Rules (`StrongPassword`, `Slug`, `HexColor`, `Base64`).
- Custom Blade Directives (`@active`, `@money`, `@date`).
