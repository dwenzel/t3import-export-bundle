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
ddev t3-switch 13            # configures, installs and sets up TYPO3 13
```

Open https://t3import-export-bundle.ddev.site/typo3/ and log in with `admin` / `Password.1`.

## Switching TYPO3 versions

```bash
ddev t3-switch               # list versions, show the active one
ddev t3-switch 11            # switch to TYPO3 11
ddev t3-switch 12 --keep-branch   # keep the currently checked out extension branch
```

`t3-switch` checks out the extension branch mapped to the version (it refuses if
`packages/t3import_export` has uncommitted changes), writes
`.ddev/config.zz-version.yaml` (PHP version, docroot, composer root, database),
restarts DDEV and runs `composer install` and `composer bundle:setup` in the
instance. Data of each version stays in its own database.

The mapping of versions to PHP and extension branches is in `.ddev/versions`.

## Layout

| Path                         | Purpose                                                   |
|------------------------------|-----------------------------------------------------------|
| `.ddev/`                     | DDEV configuration and custom commands                    |
| `packages/t3import_export/`  | Working copy of the extension (own git repo, gitignored)  |
| `instances/v11`, `v12`, `v13`| One TYPO3 installation (composer root) per major version  |
| `instances/shared/`          | Development settings and setup script used by all instances |
| `Build/lint.sh`              | Lint the bundle (shellcheck, editorconfig)                |
| `ROADMAP.md`                 | Plan for the dev environment and the branch consolidation |

## TYPO3 instances

| Instance | TYPO3 | PHP | Extension branch              | Database | Console |
|----------|-------|-----|-------------------------------|----------|---------|
| v11      | 11.5  | 8.2 | `feature/version11compatible` | `t3_v11` | 7.x (`typo3cms`) |
| v12      | 12.4  | 8.3 | `develop`                     | `t3_v12` | 8.x     |
| v13      | 13.4  | 8.3 | `feature/v13compatible`       | `t3_v13` | 8.x/9.x |

Each instance requires the extension from `packages/t3import_export` through a
symlinked path repository. The database connection is taken from the
environment variable `TYPO3_INSTANCE_DB` (see `instances/shared/development.php`).

Backend login for all instances: `admin` / `Password.1`.

TYPO3 11 and 12 are out of free support. Their last public releases depend on
packages with known security advisories, so `config.audit.block-insecure` is
disabled in these two instances. They are meant for local development only.

## Commands

| Command                         | Description                                                    |
|---------------------------------|----------------------------------------------------------------|
| `ddev ext-checkout [branch]`    | Clone the extension, optionally check out a branch             |
| `ddev t3-switch [major]`        | Switch the active TYPO3 version, or list versions              |
| `ddev composer bundle:setup`    | Install TYPO3 in the active instance (idempotent)              |

## Linting the bundle

```bash
Build/lint.sh
```
