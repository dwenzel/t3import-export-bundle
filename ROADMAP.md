# Roadmap

Goal: one development environment for all maintained TYPO3 versions of
t3import_export, and an extension repository that follows the branching model
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

| TYPO3 | Extension branch    | Version line |
|-------|---------------------|--------------|
| 14    | `main` (later)      | 4.x          |
| 13.4  | `main`              | 3.x          |
| 12.4  | `support/typo3-v12` | 2.x          |
| 11.5  | `support/typo3-v11` | to be decided (see extension#19) |

## Phase 1: Development environment (bundle)

| Status | Issue | Item |
|--------|-------|------|
| done   |       | DDEV base configuration, `ddev ext-checkout` |
| done   |       | TYPO3 instances v11, v12, v13 with separate databases |
| done   |       | `ddev t3-switch <version>` |
| open   | #2    | `ddev ext` for the extension's tests and linters |
| open   | #3    | CI for the bundle |
| open   | #1    | Branching model, CONTRIBUTING.md, this roadmap |
| open   | #6    | Lint script reads stale files after in-place edits |

## Phase 2: Branching model in the extension

| Status | Issue | Item |
|--------|-------|------|
| open   | extension#18 | Rename `master` to `main`, create `support/typo3-v11` and `support/typo3-v12`, protect branches, CONTRIBUTING.md, support matrix, remove `develop`, `release/*` and stale branches (`archive/*` tags for unmerged work) |
| open   | extension#19 | Integrate `feature/version11compatible` into `support/typo3-v11`, release |
| open   | extension#20 | Make dev dependencies of the support branches installable on PHP 8 |
| open   | extension#21 | Port TYPO3 11 fixes to TYPO3 12 and 13 where applicable |
| open   | bundle#4     | Map the bundle's TYPO3 versions to the new branches |

## Phase 3: TYPO3 13 release

| Status | Issue | Item |
|--------|-------|------|
| open   | extension#22 | Integrate `feature/v13compatible` into `main`, release 3.0.0 |
| open   |              | Release `cpsit/import-export-core` 0.1.0 (blocker for 3.0.0, separate repository) |
| open   | extension#23 | Fix editorconfig violations, make lint a required check |

## Phase 4: TYPO3 14

| Status | Issue | Item |
|--------|-------|------|
| open   | extension#24 | TYPO3 14 support on `main` (4.0.0); TYPO3 13 moves to `support/typo3-v13` |
| open   | bundle#5     | TYPO3 14 instance |
