# Flexi Contracts

[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)
[![PHP Version](https://img.shields.io/badge/php-%3E%3D7.4-blue)](https://php.net)
[![PSR Compatible](https://img.shields.io/badge/PSR-Compatible-green)](https://www.php-fig.org/psr/)

**Contracts and PSR dependencies for Flexi Framework** - Central interface package that ensures a single point of dependency between different pieces of the Flexi Framework ecosystem.

## Purpose

`flexi/contracts` exists to guarantee a **unique dependency point** between the various components of the Flexi Framework (core and modules). This package serves as the foundation for maintaining loose coupling and high cohesion across the entire framework architecture.

### Key Benefits

- **🔗 Single Dependency Point**: All framework components depend on contracts, not on concrete implementations
- **📦 Modular Architecture**: Modules can be developed independently while sharing common interfaces
- **🎯 Loose Coupling**: Core and modules communicate through well-defined contracts
- **✅ PSR Standards Compliance**: Full compatibility with PHP-FIG PSR standards
- **🔄 Flexibility**: Optional base classes and interfaces for common use cases

## What's Included

This package includes:

1. **PSR Standards Dependencies** - Complete PSR compatibility out of the box
2. **Framework Interfaces** - Core contracts for the Flexi ecosystem
3. **Base Classes** - Optional abstract classes for common patterns
4. **Value Objects** - Reusable immutable value objects
5. **Utility Traits** - Helper traits for common functionality

## Installation

```bash
composer require flexi/contracts
```

## Package Contents

### 📋 Interfaces (26 contracts)

The package provides interfaces for all major framework components:

#### **CQRS Pattern**

- `BusInterface` - Command/Query bus abstraction
- `HandlerInterface` - Handler for commands and queries
- `DTOInterface` - Data Transfer Object contract
- `CliDTOInterface` - CLI-specific DTO contract
- `MessageInterface` - Message contract for responses

#### **Event Management**

- `EventBusInterface` - Event dispatcher abstraction
- `EventInterface` - Event contract
- `EventListenerInterface` - Event listener contract

#### **Data Access**

- `RepositoryInterface` - Generic repository pattern
- `CriteriaInterface` - Query criteria pattern
- `EntityInterface` - Domain entity contract
- `CollectionInterface` - Collection contract

#### **Persistence & Caching**

- `CacheInterface` - Cache abstraction (PSR-16 compatible)
- `SessionStorageInterface` - Session storage contract
- `LogRepositoryInterface` - Log persistence contract
- `LogInterface` - Log entity contract

#### **Configuration**

- `ConfigurationInterface` - Configuration access contract
- `ConfigurationRepositoryInterface` - Configuration repository contract
- `SecretProviderInterface` - Secret/credential provider contract

#### **Dependency Injection**

- `ObjectBuilderInterface` - Object builder/factory contract
- `ServiceDefinitionInterface` - Service definition contract
- `FactoryInterface` - Generic factory contract

#### **UI & Templates**

- `TemplateEngineInterface` - Template rendering engine
- `TemplateInterface` - Template representation
- `TemplateLocatorInterface` - Template discovery

#### **Foundation**

- `ValueObjectInterface` - Value object contract

### 🏗️ Base Classes (8 implementations)

Optional abstract and concrete classes for common patterns:

- `Collection` - Generic collection implementation
- `ObjectCollection` - Type-safe object collection
- `EventListener` - Abstract event listener base
- `HttpHandler` - Abstract HTTP request handler (PSR-15)
- `Log` - Log entity implementation
- `PlainTextMessage` - Simple message implementation
- `PsrLogger` - PSR-3 logger adapter

#### Criteria Pattern

- `AnyCriteria` - Null object pattern for criteria

### 💎 Value Objects (6 immutables)

Domain-driven value objects:

- `ID` - Unique identifier
- `Version` - Semantic version representation
- `LogLevel` - PSR-3 log levels
- `CollectionType` - Collection type descriptor
- `Order` - Sort order (ASC/DESC)
- `Operator` - Comparison operators

### 🛠️ Utility Traits (6 helpers)

Reusable functionality:

- `CacheKeyGeneratorTrait` - Cache key generation
- `FileHandlerTrait` - File system operations
- `GlobFileReader` - Glob pattern file reading
- `JsonFileReader` - JSON file parsing
- `InstalledModulesProviderTrait` - Module discovery
- `OSDetectorTrait` - Operating system detection

## PSR Standards Included

This package includes and enforces compatibility with:

- **PSR-1**: Basic Coding Standard
- **PSR-3**: Logger Interface (via `psr/log`)
- **PSR-6**: Caching Interface (via `psr/cache`)
- **PSR-7**: HTTP Message Interface (via `psr/http-message`)
- **PSR-11**: Container Interface (via `psr/container`)
- **PSR-14**: Event Dispatcher (via `psr/event-dispatcher`)
- **PSR-15**: HTTP Server Request Handlers (via `psr/http-server-handler` & `psr/http-server-middleware`)
- **PSR-16**: Simple Cache (via `psr/simple-cache`)
- **PSR-17**: HTTP Factories (via `psr/http-factory`)
- **PSR-18**: HTTP Client (via `psr/http-client`)
- **PSR-20**: Clock (via `psr/clock`)

## Usage Philosophy

### For Framework Core

The core should:

- ✅ Depend on contracts from this package
- ✅ Implement interfaces defined here
- ❌ Never create its own interfaces that modules need
- ❌ Never depend on module implementations

### For Modules

Modules should:

- ✅ Depend on contracts from this package
- ✅ Implement interfaces defined here
- ✅ Use optional base classes if needed
- ✅ Declare explicit dependency on other modules in composer.json to resolve automatically and avoid incompatibilities
- ❌ Never depend on the core directly

### Optional Usage

All base classes, value objects, and traits are **optional**. You can:

- Use only the interfaces you need
- Implement your own base classes
- Create custom value objects
- Skip utility traits if not needed

## Example: Using Contracts

```php
use Flexi\Contracts\Interfaces\HandlerInterface;
use Flexi\Contracts\Interfaces\DTOInterface;
use Flexi\Contracts\Interfaces\MessageInterface;
use Flexi\Contracts\Classes\PlainTextMessage;

class MyCommandHandler implements HandlerInterface
{
    public function handle(DTOInterface $command): MessageInterface
    {
        // Your business logic here
        return new PlainTextMessage('Command executed successfully');
    }
}
```

## Example: Using Value Objects

```php
use Flexi\Contracts\ValueObjects\ID;
use Flexi\Contracts\ValueObjects\Version;

$userId = new ID('user-123');
$appVersion = new Version(1, 5, 0);

echo $appVersion; // "1.5.0"
```

## Example: Using Base Classes

```php
use Flexi\Contracts\Classes\EventListener;
use Flexi\Contracts\Interfaces\EventInterface;

class MyEventListener extends EventListener
{
    public function handleEvent(EventInterface $event): void
    {
        // React to the event
        $data = $event->getData();
        // Process...
    }
}
```

Event listeners implement `EventListenerInterface` independently from `HandlerInterface`. Their `handle()` method receives an `EventInterface` and returns `void`; command and query handlers continue to return `MessageInterface`.

## Configuration schemas

The versioned JSON Schemas for Flexi module configuration are maintained in [`schemas/configuration/v1/`](schemas/configuration/v1/). This package is the single source of truth; the core and modules should validate against these definitions. Module-specific configuration files may use their own formats and schemas.

The shared schemas cover services, routes, listeners, commands, and queries. The listener schema reflects the grouped event-to-listener-array format used by the published modules.

## Requirements

- PHP 7.4 or higher
- Composer

## License

MIT License - see [LICENSE](LICENSE) file for details.

## Contributing

This package is part of the Flexi Framework ecosystem. Contributions are welcome following these guidelines:

1. **Interface Changes**: Require careful consideration as they affect the entire ecosystem
2. **New Interfaces**: Should solve common problems across multiple modules
3. **Base Classes**: Should be optional and follow SOLID principles
4. **PSR Compliance**: Must maintain compatibility with PSR standards

## Versioning

This package follows [Semantic Versioning](https://semver.org/):

- **MAJOR**: Breaking changes to interfaces
- **MINOR**: New interfaces or optional features
- **PATCH**: Bug fixes and documentation

## Links

- [Flexi Framework](https://github.com/CubaDevOps/flexi)
- [Documentation](https://github.com/CubaDevOps/flexi/tree/main/docs)
- [Report Issues](https://github.com/CubaDevOps/flexi-contracts/issues)

## Architecture

```
┌─────────────────────────────────────────┐
│         Flexi Framework Core            │
│     (Business Logic & Orchestration)    │
└─────────────┬───────────────────────────┘
              │ depends on
              ↓
┌─────────────────────────────────────────┐
│       flexi/contracts                   │
│  (Interfaces, Base Classes, PSR deps)   │
└─────────────┬───────────────────────────┘
              ↑ depends on
              │
┌─────────────┴───────────────────────────┐
│                                         │
│  ┌──────────────┐  ┌──────────────┐    │
│  │ Auth Module  │  │ Cache Module │    │
│  └──────────────┘  └──────────────┘    │
│  ┌──────────────┐  ┌──────────────┐    │
│  │  UI Module   │  │  Log Module  │    │
│  └──────────────┘  └──────────────┘    │
│         ... more modules ...            │
└─────────────────────────────────────────┘
```

## Support

For questions and support:

- Open an issue on [GitHub](https://github.com/CubaDevOps/flexi-contracts/issues)
- Check the [Flexi Framework documentation](https://github.com/CubaDevOps/flexi/tree/main/docs)

---

Made with ❤️ for the Flexi Framework ecosystem
