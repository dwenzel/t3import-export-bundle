# Roadmap

Goal: one development environment for all maintained TYPO3 versions of
Import & Export, and an extension repository that follows the branching model
described in [CONTRIBUTING.md](CONTRIBUTING.md).

Issues: [bundle](https://github.com/dwenzel/t3import-export-bundle/issues),
[extension](https://github.com/dwenzel/t3import_export/issues)

## Starting point (November 2026)

| TYPO3 | Extension branch              | Last tag | Notes |
|-------|-------------------------------|----------|-------|
| 9/10  | `master` history              | 1.0.5    | not maintained |
| 11.5  | `feature/version11compatible` | none     | 18 commits on top of 1.0.4, recent bugfixes, never released |
| 12.4  | `master` / `develop`          | 2.0.1    | `develop` has no content difference to `master` |
| 13.4  | `feature/v13compatible`       | none     | based on `develop`; depends on an unreleased `cpsit/import-export-core` |

In addition there were `release/*` branches (all tagged) and several feature
branches from 2016 to 2020.

## Target

| TYPO3 | Extension branch    | Version line | State |
|-------|---------------------|--------------|-------|
| 14    | `main` (later)      | 4.x          | planned |
| 13.4  | `main`              | 3.x          | 3.0.0 released |
| 12.4  | `support/typo3-v12` | 2.x          | 2.0.1 |
| 11.5  | `support/typo3-v11` | to be decided (see extension#19) | integrated, not released |

The core library [cpsit/import-export-core](https://github.com/CPS-IT/import-export-core)
(required by 3.x) has its own roadmap in its `Documentation/Architecture.md`;
0.1.0 is released.

## Phase 1: Development environment (bundle)

| Status | Issue | Item |
|--------|-------|------|
| done   |       | DDEV base configuration, `ddev ext-checkout` |
| done   |       | TYPO3 instances v11, v12, v13 with separate databases |
| done   |       | `ddev t3-switch <version>` |
| done   | #2    | `ddev ext` for the extension's tests and linters |
| done   | #3    | CI for the bundle |
| done   | #1    | Branching model, CONTRIBUTING.md, this roadmap |
| done   | #12   | Check out the core library next to the extension |
| open   | #6    | Lint script and tests read stale files after in-place edits |

## Phase 2: Branching model in the extension

| Status | Issue | Item |
|--------|-------|------|
| done   | extension#18 | Rename `master` to `main`, support branches, rulesets, CONTRIBUTING.md, support matrix, stale branches removed (`archive/*` tags); open: remove `develop` after triaging extension#16 and #17 |
| open   | extension#19 | `feature/version11compatible` is integrated into `support/typo3-v11`; open: version number and release |
| open   | extension#20 | Make dev dependencies of the support branches installable on PHP 8 |
| open   | extension#21 | Blockers for 3.0.0 fixed; open: remaining fixes for 3.0.x and `support/typo3-v12` |
| done   | bundle#4     | Map the bundle's TYPO3 versions to the new branches |

## Phase 3: TYPO3 13 release

| Status | Issue | Item |
|--------|-------|------|
| done   | extension#22 | Integrate `feature/v13compatible` into `main`, release 3.0.0 |
| done   |              | Release `cpsit/import-export-core` 0.1.0 |
| done   | extension#29 | Use the correct extension name ("Import & Export") in the documentation |
| open   | extension#31 | CI: done for `main` (required checks); open: support branches |
| open   | extension#23 | Fix editorconfig violations, make lint a required check |
| open   | extension#28 | Publish tagged releases to TER automatically (TER only has outdated versions) |

## Phase 4: TYPO3 14

| Status | Issue | Item |
|--------|-------|------|
| open   | extension#24 | TYPO3 14 support on `main` (4.0.0); TYPO3 13 moves to `support/typo3-v13` |
| open   | bundle#5     | TYPO3 14 instance |
