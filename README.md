# Architecture Testing Package

A PHP package for enforcing architectural rules and coding standards in Laravel applications using [Pest PHP](https://pestphp.com/).

## 📋 Overview

This package provides automated architecture tests to ensure your Laravel application follows consistent naming conventions, inheritance patterns, and layered architecture principles. It helps maintain code quality and architectural integrity across your project.

## ✨ Features

### 🎯 Naming Convention Tests
- **Controllers**: Ensures all controller files and classes end with `Controller` suffix
- **Services**: Validates service files and classes have `Service` suffix
- **Repositories**: Checks repository files and classes use `Repository` suffix
- **Models**: Verifies model files and classes end with `Model` suffix (optional)

### 🏗️ Inheritance Tests
- **Controllers**: All controllers must extend `BaseController`
- **Services**: All services must extend `BaseService` (with exceptions for `JWTService`)
- **Models**: All models must extend `BaseModel` (optional)

### 🔒 Layer Separation Tests
- **Services**: Can only be used in Controllers
- **Repositories**: Can only be used in Services
- **Models**: Can only be used in Repositories (with specific exceptions)

### 🚫 Forbidden Functions
Prevents usage of debugging and unsafe functions:
- `dd`, `ddd`, `die`, `dump`, `ray`, `sleep`, `eval`, `print_r`, `var_dump`

## 📦 Installation

Install the package via Composer:

```bash
composer require --dev dergahab/arch-testing
```

## 🚀 Usage

### Running Tests

Run all architecture tests:

```bash
./vendor/bin/pest
```

Run specific test files:

```bash
./vendor/bin/pest tests/Feature/Arch/ControllersTest.php
./vendor/bin/pest tests/Feature/Arch/ServicesTest.php
./vendor/bin/pest tests/Feature/Arch/RepositoriesTest.php
```

### Expected Directory Structure

This package assumes your Laravel application follows this structure:

```
app/
├── Http/
│   └── Controllers/
│       ├── BaseController.php
│       └── *Controller.php
├── Services/
│   ├── BaseService.php
│   └── *Service.php
├── Repositories/
│   └── *Repository.php
└── Models/
    ├── BaseModel.php
    └── *Model.php
```

## 📝 Test Suites

### Controllers Test (`ControllersTest.php`)
1. ✅ All controller files must end with `Controller.php`
2. ✅ All controller classes must end with `Controller`
3. ✅ All controllers must extend `BaseController`

### Services Test (`ServicesTest.php`)
1. ✅ All service files must end with `Service.php`
2. ✅ All service classes must end with `Service`
3. ✅ All services must extend `BaseService` (except `BaseService` and `JWTService`)

### Repositories Test (`RepositoriesTest.php`)
1. ✅ All repository files must end with `Repository.php`
2. ✅ All repository classes must end with `Repository`

### Models Test (`ModelsTest.php`)
1. ⏭️ All model files must end with `Model.php` (skipped by default)
2. ⏭️ All model classes must end with `Model` (skipped by default)
3. ⏭️ All models must extend `BaseModel` (skipped by default)

### Architecture Rules (`NotUseInTest.php`)
1. ✅ Services can only be used in Controllers
2. ✅ Repositories can only be used in Services
3. ✅ Models can only be used in Repositories (with middleware/request exceptions)
4. ✅ Forbidden debugging functions cannot be used anywhere

## ⚙️ Configuration

### Skipping Tests

Some tests are skipped by default (like Model suffix tests). You can enable them by removing the `->skip()` method:

```php
// Before (skipped)
it('ensures all model files have the Model suffix', function () {
    // ...
})->skip('DTBExplorationType');

// After (enabled)
it('ensures all model files have the Model suffix', function () {
    // ...
});
```

### Adding Exceptions

You can add exceptions to inheritance or usage rules by modifying the test files:

```php
// Add exception for specific service
if ($className === 'App\\Services\\BaseService' || $className === 'App\\Services\\CustomService') {
    continue;
}
```

## 🛠️ Requirements

- PHP 8.0 or higher
- Laravel 10.x or higher
- Pest PHP 2.35 or higher
- Orchestra Testbench 8.0 or higher

## 📄 License

This package is open-sourced software licensed under the [MIT license](LICENSE).

## 👤 Author

**Dergah**

## 🤝 Contributing

Contributions, issues, and feature requests are welcome!

## 📚 Related Packages

- [Pest PHP](https://pestphp.com/) - Testing Framework
- [Pest Architecture Plugin](https://pestphp.com/docs/arch-testing) - Architecture Testing
- [Orchestra Testbench](https://github.com/orchestral/testbench) - Laravel Package Testing

## 💡 Tips

1. **Run tests in CI/CD**: Add these tests to your continuous integration pipeline
2. **Pre-commit hooks**: Use tools like Husky to run tests before commits
3. **Custom rules**: Extend the tests to match your specific architecture needs
4. **Team standards**: Use this package to enforce team coding standards automatically

---

Made with ❤️ for better Laravel architecture
