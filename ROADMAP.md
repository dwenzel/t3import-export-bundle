# Roadmap

Goal: one development environment for all maintained TYPO3 versions of
Import & Export, and an extension repository that follows the branching model
described in [CONTRIBUTING.md](CONTRIBUTING.md).

Issues: [bundle](https://github.com/dwenzel/t3import-export-bundle/issues),
[extension](https://github.com/dwenzel/t3import_export/issues),
[core library](https://github.com/CPS-IT/import-export-core/issues),
[t3extension_tools](https://github.com/dwenzel/t3extension_tools/issues)

## Starting point (November 2026)

| TYPO3 | Extension branch              | Last tag | Notes |
|-------|-------------------------------|----------|-------|
| 9/10  | `master` history              | 1.0.5    | not maintained |
| 11.5  | `feature/version11compatible` | none     | 18 commits on top of 1.0.4, recent bugfixes, never released |
| 12.4  | `master` / `develop`          | 2.0.1    | `develop` has no content difference to `master` |
| 13.4  | `feature/v13compatible`       | none     | based on `develop`; depends on an unreleased `cpsit/import-export-core` |

In addition there were `release/*` branches (all tagged) and several feature
branches from 2016 to 2020.

## Current state

| TYPO3 | Extension branch    | Version line | Latest release | State |
|-------|---------------------|--------------|----------------|-------|
| 15    | -                   | 5.x          | none           | work branch `feature/116-typo3-v15`, TYPO3 15 in development |
| 14    | `main` (later)      | 4.x          | none           | planned, work branch `feature/24-typo3-v14` |
| 13.4  | `main`              | 3.x          | 3.1.1          | maintained |
| 12.4  | `support/typo3-v12` | 2.x          | 2.0.3          | bugfixes |
| 11.5  | `support/typo3-v11` | 1.x          | 1.1.1          | bugfixes |

All releases since 1.1.0 are published to TER by the tag push.

The core library [cpsit/import-export-core](https://github.com/CPS-IT/import-export-core)
(required by 3.x) has its own roadmap in its `Documentation/Architecture.md`.
0.1.0 is released; 0.2.0 is in progress.

[t3extension_tools](https://github.com/dwenzel/t3extension_tools) (required by
all versions) is on TER with 3.0.0 (TYPO3 11.5 - 12.4), 4.1.0 (TYPO3 12.4) and
6.1.1 (TYPO3 13.4 - 14.3).

## Phase 1: Development environment (bundle) - done

| Status | Issue | Item |
|--------|-------|------|
| done   |       | DDEV base configuration, `ddev ext-checkout` |
| done   |       | TYPO3 instances v11, v12, v13 with separate databases |
| done   |       | `ddev t3-switch <version>` |
| done   | #2    | `ddev ext` for the extension's tests and linters |
| done   | #3    | CI for the bundle |
| done   | #1    | Branching model, CONTRIBUTING.md, this roadmap |
| done   | #12   | Check out the core library next to the extension |
| done   | #6    | Lint script and tests read stale files after in-place edits |

## Phase 2: Branching model in the extension - done

| Status | Issue | Item |
|--------|-------|------|
| done   | extension#18 | Rename `master` to `main`, support branches, rulesets, CONTRIBUTING.md, support matrix, stale branches removed (`archive/*` tags), `develop` removed |
| done   | extension#19 | `feature/version11compatible` integrated into `support/typo3-v11`, released as 1.1.0 |
| done   | extension#20 | Dev dependencies of the support branches installable on PHP 8 |
| done   | extension#21 | TYPO3 11 fixes classified; generic bugs fixed on the current branches |
| done   | bundle#4     | Map the bundle's TYPO3 versions to the new branches |

## Phase 3: TYPO3 13 releases

| Status | Issue | Item |
|--------|-------|------|
| done   | extension#22 | Integrate `feature/v13compatible` into `main`, release 3.0.0 |
| done   |              | Release `cpsit/import-export-core` 0.1.0 |
| done   | extension#29 | Use the correct extension name ("Import & Export") in the documentation |
| done   | extension#31 | GitHub Actions on all maintained branches, Travis CI removed |
| done   | extension#23 | Fix editorconfig violations, lint as required check |
| done   | extension#28 | Publish tagged releases to TER automatically |
| done   | extension#83 | Release 3.0.1 |
| done   | extension#99 | Release 3.1.0: YAML features, TypoScript configuration deprecated (extension#75), fixes extension#93 and extension#97 |
| done   | extension#106 | Release 3.1.1: allow t3extension_tools 6.x (extension#104), so that installations from TER can resolve the dependency |
| done   | extension#108 | Support branches: declare the t3extension_tools dependency, released as 2.0.3 and 1.1.1 |

## Phase 4: Core 0.2 and TYPO3 14 (extension 4.0)

| Status | Issue | Item |
|--------|-------|------|
| open   | core 0.2.0 milestone | Core library 0.2: processor in the core, streams, filters, ID map, DBAL source and target |
| open   | extension#71 | Adopt import-export-core 0.2 (breaking for custom components) |
| open   | extension#75 | Remove TypoScript configuration and content rendering (deprecated in 3.1) |
| open   | extension#24 | TYPO3 14 support on `main` (4.0.0); TYPO3 13 moves to `support/typo3-v13` |
| done   | bundle#5     | TYPO3 14 instance (extension work branch `feature/24-typo3-v14`) |
| open   | extension#117 | Backend modules hidden in TYPO3 14 (module access) |
| open   | extension#118 | Remove `ext_tables.php` |
| open   | extension#119 | Tests fail on TYPO3 14; `WriteFile`/`MoveFile` use removed `ResourceFactory` methods |

## Phase 5: TYPO3 15 (extension 5.0)

TYPO3 15 is in development. The bundle has an instance for it, so that
incompatibilities show up early.

| Status | Issue | Item |
|--------|-------|------|
| done   | bundle#19    | TYPO3 15 instance (15.0.x-dev, PHP 8.5) |
| open   | extension#116 | TYPO3 15 support; dev dependencies (phpstan-typo3, testing-framework, typoscript-lint, typo3-console) not available for 15 yet |
| open   | core#60      | Allow Symfony 8 |
| open   | t3extension_tools#22 | TYPO3 15 support, typo3-console optional |
