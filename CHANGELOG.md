# Changelog

All notable changes to `skywalker-labs/toolkit` will be documented in this file.

## [1.4.0] - 2026-03-05

### Added
- Absolute multi-version compatibility (PHP `^7.0|^8.0|^9.0` & Laravel `^5.5` to `^12.0`).
- Global `filesystem()` and `validator()` helpers.
- Automated `ToolkitServiceProvider` for Laravel ecosystem auto-discovery.
- Robust, flattened `src/` directory separating Concerns, Database, Validation, Http, and Routing dynamically.

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
