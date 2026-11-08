# t3import-export-bundle

DDEV based development environment for the TYPO3 extension
[Import & Export](https://github.com/dwenzel/t3import_export)
(extension key `t3import_export`, package `cpsit/t3import_export`).

The extension is maintained for several TYPO3 versions. This bundle
contains one TYPO3 installation per version and lets you switch between them.

## Requirements

* DDEV >= 1.24
* Docker (also used by `Build/lint.sh`)

## Quick start

```bash
ddev start
ddev ext-checkout            # clones the extension and the core library into packages/
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
| `packages/import-export-core/` | Working copy of the core library `cpsit/import-export-core` (own git repo, gitignored) |
| `instances/v11`, `v12`, `v13`| One TYPO3 installation (composer root) per major version  |
| `instances/shared/`          | Development settings and setup script used by all instances |
| `Build/lint.sh`              | Lint the bundle (shellcheck, editorconfig)                |
| `ROADMAP.md`                 | Plan for the dev environment and the branch consolidation |

## TYPO3 instances

| Instance | TYPO3 | PHP | Extension branch              | Database | Console |
|----------|-------|-----|-------------------------------|----------|---------|
| v11      | 11.5  | 8.2 | `feature/version11compatible` | `t3_v11` | 7.x (`typo3cms`) |
| v12      | 12.4  | 8.3 | `support/typo3-v12`           | `t3_v12` | 8.x     |
| v13      | 13.4  | 8.3 | `feature/v13compatible`       | `t3_v13` | 8.x/9.x |

Each instance requires the extension from `packages/t3import_export` through a
symlinked path repository. The TYPO3 13 branch of the extension also requires
the core library `cpsit/import-export-core`; the v13 instance takes it from
`packages/import-export-core` in the same way, or from Packagist if the clone
is missing. The database connection is taken from the
environment variable `TYPO3_INSTANCE_DB` (see `instances/shared/development.php`).

Backend login for all instances: `admin` / `Password.1`.

TYPO3 11 and 12 are out of free support. Their last public releases depend on
packages with known security advisories, so `config.audit.block-insecure` is
disabled in these two instances. They are meant for local development only.

## Commands

| Command                         | Description                                                    |
|---------------------------------|----------------------------------------------------------------|
| `ddev ext-checkout [branch]`    | Clone the extension and the core library, optionally check out a branch of the extension |
| `ddev t3-switch [major]`        | Switch the active TYPO3 version, or list versions              |
| `ddev composer bundle:setup`    | Install TYPO3 in the active instance (idempotent)              |
| `ddev ext <composer args>`      | Run composer in `packages/t3import_export` (tests, linters)    |

## Testing the extension

`ddev ext` runs the extension's own composer scripts with the PHP version of the
active TYPO3 instance. Functional tests use the DDEV database server.

```bash
ddev ext update              # install the extension's dev dependencies (after every branch switch)
ddev ext test:unit
ddev ext test:functional
ddev ext lint                # only on branches that define it
ddev ext sca
```

Run `ddev ext update` after switching versions: the branches use different
build directories (`.Build/` vs. `.build/`), which are the same directory on
case-insensitive file systems (macOS).

Composer fetches GitHub repositories via HTTPS, also when they are referenced by
an SSH URL. For private repositories, forward your SSH keys with `ddev auth ssh`
(needed again after `ddev poweroff`).

Known limitation: the extension branches for TYPO3 11 and 12 currently cannot
install their dev dependencies (`roave/security-advisories` conflicts with all
TYPO3 11.5 releases; `nimut/testing-framework` 5.x requires PHP < 7.5). This is
tracked in ROADMAP.md and will be fixed in the support branches.

## Linting the bundle

```bash
Build/lint.sh
```

## Contributing

See [CONTRIBUTING.md](CONTRIBUTING.md) for the branching model and workflow,
and [ROADMAP.md](ROADMAP.md) for planned work.
