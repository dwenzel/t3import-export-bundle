# TYPO3 Import/Export Bundle

This project serves as development environment for the TYPO3 Import/Export
extension (`cpsit/t3import_export`). It is not intended for use in production.

This is a flexible and extensible TYPO3 13.4 extension for importing data
from various sources into TYPO3 and exporting from TYPO3 to different targets.

## Project Overview

This project provides a modular framework for handling complex data import and
export operations in TYPO3. The system supports multiple data sources and
targets including databases, XML files, CSV files, and more.

### Main Components

- **t3import_export**: Main import/export extension
- **import-export-core**: Core components and shared functionality
- **t3extension-tools**: Utility extension dependency

### Supported Data Sources & Targets

- **Databases**: TYPO3 internal and external databases
- **File Formats**: XML, CSV
- **Other**: Repository objects, Queue system

## Architecture

The extension uses a component-based architecture with the following processing flow:

1. **Initializers**: Pre-execution setup (e.g., TruncateTables, DeleteFromTable)
2. **PreProcessors**: Raw data manipulation (e.g., MapFields, LookUpDB)
3. **Converters**: Data format transformation (e.g., ArrayToDomainObject, ArrayToXMLStream)
4. **PostProcessors**: Converted data processing (e.g., SetL10nParent, RecreateSlug)
5. **Finishers**: Post-execution cleanup (e.g., ClearCache, ValidateXML)

### Configuration Options

- **TypoScript**: Traditional TYPO3 configuration
- **YAML**: Modern, readable configuration format (recently added)

## Local Development with DDEV

### System Requirements

- TYPO3 13.4
- PHP 8.4
- Apache FPM webserver
- MariaDB 10.4

### Setup

```bash
# Start the DDEV environment
ddev start

# Install dependencies
ddev composer install
```

### Admin Account

| Username | Password        |
|----------|-----------------|
| admin    | AdminPassword!1 |

## Development Commands

### Quality Assurance

```bash
# Run all linters
ddev composer lint

# Individual linters
ddev composer lint:composer    # Check composer.json normalization
ddev composer lint:editorconfig # Check editorconfig compliance
ddev composer lint:php         # Check PHP coding style
ddev composer lint:typoscript  # Check TypoScript style

# Fix issues
ddev composer fix              # Fix all issues
ddev composer fix:composer     # Fix composer.json issues
ddev composer fix:editorconfig # Fix editorconfig issues
ddev composer fix:php          # Fix PHP coding style issues
```

### Static Code Analysis

```bash
# Run all static code analyzers
ddev composer sca

# Run PHPStan analysis
ddev composer sca:php
```

### Code Migrations

```bash
# Run all migrations
ddev composer migration

# Run TYPO3 Rector
ddev composer migration:rector
```

### Testing

```bash
# Run all tests
ddev composer test

# Run unit tests only
ddev composer test:unit

# Run specific unit tests
ddev exec "cd packages/t3import_export && .Build/bin/phpunit -c Tests/Build/UnitTests.xml Tests/Unit/Component/PreProcessor/MapFieldsTest.php"
```

## Usage

### Command Line Interface

```bash
# Import data sets
vendor/bin/typo3 t3import-export:import-set <set-name>

# Export data sets
vendor/bin/typo3 t3import-export:export-set <set-name>

# Using YAML configuration
vendor/bin/typo3 t3import-export:import-set --yaml-config path/to/config.yaml
```

### Backend Module

Tasks can also be executed through the TYPO3 backend module interface.

### Scheduler Integration

Import/export tasks can be scheduled using TYPO3's scheduler system.

## Configuration Examples

### YAML Configuration

```yaml
import:
  tasks:
    csv2ttContent:
      label: "CSV to tt_content"
      description: |
        Configuration example for an import task. This task uses a CSV file as data source
        and imports into the table tt_content.

      source:
        class: "CPSIT\\T3importExport\\Persistence\\DataSourceCSV"
        config:
          file: "EXT:t3import_export/Resources/Public/Examples/CSV/csv2ttContent.csv"

      preProcessors:
        1:
          class: "CPSIT\\T3importExport\\Component\\PreProcessor\\SetFieldValue"
          config:
            targetField: "pid"
            value: 1

      target:
        class: "CPSIT\\T3importExport\\Persistence\\DataTargetDB"
        config:
          table: "tt_content"
```

## Project Structure

```
/config                     # TYPO3 site configuration
/documentation             # Project documentation
  /issues                 # Known issues and solutions
  /workreports           # Development reports
/packages                 # Local packages and extensions
  /t3import_export       # Main import/export extension
  /import-export-core    # Core components
/public                   # Web document root
/var                     # TYPO3 variable data (cache, logs)
/vendor                  # Composer dependencies
```

## Quality Standards

- **PHPStan**: Maximum level analysis (`max`)
- **PHP-CS-Fixer**: Enforced coding style
- **TypoScript Linting**: Style compliance
- **EditorConfig**: Consistent file formatting
- **Composer Normalization**: Standardized dependencies

## Recent Developments

### YAML Configuration Support

Recently implemented YAML configuration support providing:

- **Improved Readability**: Cleaner syntax compared to TypoScript
- **Better IDE Support**: Enhanced syntax highlighting and validation
- **Reduced Errors**: Stricter syntax prevents common configuration mistakes
- **Backward Compatibility**: Coexists with existing TypoScript configurations

### Current Focus

- TYPO3 13.4 compatibility updates
- PHPUnit 12 migration
- Code quality improvements
- Test structure modernization

## Contributing

### Development Guidelines

- Always execute PHP scripts including composer within DDEV
- The `packages/t3import_export` and `packages/import-export-core` directories are separate git repositories
- Commit changes in package directories, not in the root directory
- Run unit tests before committing changes
- Follow existing component interface design patterns

### Git Workflow

```bash
# Commit changes in package directories
cd packages/t3import_export
git add .
git commit -m "Your commit message"

# Or for core components
cd packages/import-export-core
git add .
git commit -m "Your commit message"
```

## Known Issues

See `/documentation/issues/` for current known issues and their solutions, including PHPStan analysis results and resolution strategies.

## Documentation

- **Work Reports**: `/documentation/workreports/` contains detailed implementation reports
- **Issues**: `/documentation/issues/` tracks known problems and solutions
- **Examples**: Configuration examples available in package resources

## Support

For issues, feature requests, or questions about this extension, please refer to the project documentation or contact the development team.

