# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

This is a TYPO3 13.4 project focused on import/export functionality. The main components are:

- TYPO3 CMS 13.4 core system
- Custom "t3import_export" extension (main extension for import/export)
- "import-export-core" extension
- "t3extension-tools" extension as a dependency

The t3import_export extension provides a flexible framework for importing data from different sources into TYPO3 and exporting from TYPO3 to different targets. Possible data sources and targets include databases and files (XML, CSV).

## Development Environment

The project uses DDEV as the local development environment:

- TYPO3 13.4
- PHP 8.4
- Apache FPM webserver
- MariaDB 10.4

## Common Commands

### Development Setup

```bash
# Start the DDEV environment
ddev start

# Install dependencies
ddev composer install
```

### Quality Assurance

```bash
# Run all linters
ddev composer lint

# Run individual linters
ddev composer lint:composer    # Check composer.json normalization
ddev composer lint:editorconfig # Check editorconfig compliance
ddev composer lint:php         # Check PHP coding style
ddev composer lint:typoscript  # Check TypoScript style

# Fix issues
ddev composer fix              # Fix all issues
ddev composer fix:composer     # Fix composer.json issues
ddev composer fix:editorconfig # Fix editorconfig issues
ddev composer fix:php          # Fix PHP coding style issues

# Static Code Analysis
ddev composer sca              # Run all static code analyzers
ddev composer sca:php          # Run PHPStan analysis

# Automatic Code Migrations
ddev composer migration        # Run all migrations
ddev composer migration:rector # Run TYPO3 Rector

# Testing
ddev composer test             # Run all tests
ddev composer test:unit        # Run unit tests

# Run specific unit tests
ddev exec "cd packages/t3import_export && .Build/bin/phpunit -c Tests/Build/UnitTests.xml Tests/Unit/Component/PreProcessor/MapFieldsTest.php"
```

## Project Structure

- `/config`: Contains TYPO3 site configuration
- `/documentation`: Contains documentation and issue tracking
- `/packages`: Local packages and extensions
  - `/packages/t3import_export`: Main import/export extension
  - `/packages/import-export-core`: Core components for import/export
- `/public`: Web document root
- `/var`: TYPO3 variable data (cache, logs, etc.)
- `/vendor`: Composer dependencies

## Architecture Notes

The project extends TYPO3's import/export functionality with a modular component-based system:

1. **Import/Export Flow**:
   - Each task is configured via TypoScript
   - Tasks can be grouped into sets
   - Each task has a data source and a data target
   - Processing flows through components: Initializers → PreProcessors → Converters → PostProcessors → Finishers

2. **Component Types**:
   - **Initializers**: Run before task execution (e.g., TruncateTables, DeleteFromTable)
   - **PreProcessors**: Manipulate raw data before conversion (e.g., MapFields, LookUpDB)
   - **Converters**: Transform data between formats (e.g., ArrayToDomainObject, ArrayToXMLStream)
   - **PostProcessors**: Process converted data (e.g., SetL10nParent, RecreateSlug)
   - **Finishers**: Run after task completion (e.g., ClearCache, ValidateXML)

3. **Data Sources/Targets**:
   - Database (TYPO3 or external)
   - XML files
   - CSV files
   - Repository objects
   - Queue system

4. **Execution Methods**:
   - Backend module
   - Command line (`vendor/bin/typo3 t3import-export:import-set` or `t3import-export:export-set`)
   - Scheduler task

## Current Development Focus

The project is currently being updated for compatibility with TYPO3 13.4 and PHPUnit 12. Recent work includes:

- Updating unit tests for PHPUnit 12 compatibility
- Fixing test structure and removing obsolete code
- Preparing for TYPO3 13.4 compatibility

## Quality Standards

- PHPStan configured at maximum level (`max`)
- PHP-CS-Fixer for coding style enforcement
- TypoScript linting
- EditorConfig for consistent file formatting
- Composer normalization enforced

## Testing Framework

- Uses PHPUnit for unit testing
- Tests are located in `packages/*/Tests/Unit`
- Coverage reports are generated in `.build/coverage/junit.xml`

## Development Guidelines

- Always execute any PHP scripts including composer in ddev
- The directories `packages/t3import_export` and `packages/import-export-core` are separate git repositories
- Always commit changes in these directories, not in the root directory of the project
- Run unit tests before committing any changes
- When adding new components, follow the component interface design pattern