# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

This is a TYPO3 13.4 project focused on import/export functionality. The main components are:

- TYPO3 CMS 13.4 core system
- Custom "t3import_export" extension (development version in progress)
- "t3extension-tools" extension as a dependency

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
```

## Project Structure

- `/config`: Contains TYPO3 site configuration
- `/documentation`: Contains documentation and issue tracking
- `/packages`: Local packages and extensions
- `/public`: Web document root
- `/var`: TYPO3 variable data (cache, logs, etc.)
- `/vendor`: Composer dependencies

## Architecture Notes

This project extends TYPO3's import/export functionality through custom extensions:

1. `t3import_export`: Core functionality for importing and exporting data
2. `t3extension-tools`: Supporting utility functions and base classes

The project is early in development (initial setup) and appears to be enhancing TYPO3's built-in import/export capabilities found in `typo3/cms-impexp`.

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