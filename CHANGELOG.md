All notable changes to `skywalker-labs/toolkit` will be documented in this file.

## [1.5.0] - 2026-03-10

### Added
- **Aether Clean Architecture:** Migrated base classes to the `Foundation` namespace (`Dto`, `Service`, `Action`, `ValueObject`).
- **PHPStan Level 9 Compliance:** Strictly typed the entire codebase, achieving a ~82% reduction in static analysis errors.
- **Enhanced Documentation:** Comprehensive update to README and integration guides.

### Changed
- **Structural Migration:** Relocated core utilities to `Support`, and renamed `Data` to `DataObjects` for enhanced discoverability.
- **Provider Standardization:** Refactored all Service Providers and Traits for strict type safety and PSR compliance.

### Removed
- **Unused & Unusual Code:** Purged 9 redundant or speculative files/traits (`ApiResponse`, `ChainedAuditTrait`, `EphemeralAccessTrait`, `Enum`, `JsonCast`, `MoneyCast`, etc.) to minimize bundle size and technical debt.


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
- Maintain support for Laravel `^5.5` through `^12.x`.
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
