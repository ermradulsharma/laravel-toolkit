# Contributing

Contributions are welcome and will be fully credited. We accept contributions via Pull Requests on [GitHub](https://github.com/skywalker-labs/toolkit).

## ⚠️ Critical Rule: Multi-Version Compatibility
The primary purpose of **Skywalker Toolkit** is to be an indestructible baseline for packages ranging from PHP 7.0 up to 9.0+. 

**DO NOT USE PHP 8.x SPECIFIC FEATURES IN `src/`**.
- Do **not** use `declare(strict_types=1);`.
- Do **not** use union types (e.g., `string|int`).
- Do **not** use match expressions, named arguments, or property promotion.
- Maintain legacy arrays `array()` or `[]` and standard DOCBLOCKs for type hinting.

## Pull Requests

- **Coding Standard** - The easiest way to apply the conventions is to install [PHP CS Fixer](https://github.com/FriendsOfPHP/PHP-CS-Fixer).
- **Add tests!** - Your patch won't be accepted if it doesn't have adequate test coverage.
- **Document any change in behaviour** - Make sure the `README.md` and any other relevant documentation are kept up-to-date.
- **One pull request per feature** - If you want to do more than one thing, send multiple pull requests.

## Running Tests

We test across multiple environments. Verify locally with:

```bash
composer dump-autoload
vendor/bin/phpunit
```
