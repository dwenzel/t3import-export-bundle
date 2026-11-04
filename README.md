# t3import-export-bundle

DDEV based development environment for the TYPO3 extension
[t3import_export](https://github.com/dwenzel/t3import_export)
(`cpsit/t3import_export`).

The extension is maintained for several TYPO3 versions. This bundle
contains one TYPO3 installation per version and lets you switch between them.

## Requirements

* DDEV >= 1.24
* Docker (also used by `Build/lint.sh`)

## Quick start

```bash
ddev start
ddev ext-checkout            # clones the extension into packages/t3import_export
```

## Layout

| Path                         | Purpose                                                   |
|------------------------------|-----------------------------------------------------------|
| `.ddev/`                     | DDEV configuration and custom commands                    |
| `packages/t3import_export/`  | Working copy of the extension (own git repo, gitignored)  |
| `Build/lint.sh`              | Lint the bundle (shellcheck, editorconfig)                |
| `ROADMAP.md`                 | Plan for the dev environment and the branch consolidation |

## Commands

| Command                         | Description                                                    |
|---------------------------------|----------------------------------------------------------------|
| `ddev ext-checkout [branch]`    | Clone the extension, optionally check out a branch             |

## Linting the bundle

```bash
Build/lint.sh
```
