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

`t3-switch` checks out the extension branch mapped to the version, and the core
library branch if one is mapped (it refuses if either working copy has
uncommitted changes), writes
`.ddev/config.zz-version.yaml` (PHP version, docroot, composer root, database),
restarts DDEV and runs `composer install` and `composer bundle:setup` in the
instance. Then it runs `ddev ext update`, because the extension's untracked
`composer.lock` still holds the dependencies of the previous branch. With
`--no-setup`, these steps are skipped. Data of each version stays in its own
database.

The mapping of versions to PHP, extension branches and core library branches is
in `.ddev/versions`. The core library branch is only checked out, not pulled.
Update it with `git pull` in `packages/import-export-core` when needed.

## Layout

| Path                         | Purpose                                                   |
|------------------------------|-----------------------------------------------------------|
| `.ddev/`                     | DDEV configuration and custom commands                    |
| `packages/t3import_export/`  | Working copy of the extension (own git repo, gitignored)  |
| `packages/import-export-core/` | Working copy of the core library `cpsit/import-export-core` (own git repo, gitignored) |
| `instances/v11` ... `v15`    | One TYPO3 installation (composer root) per major version  |
| `instances/shared/`          | Development settings and setup script used by all instances |
| `Build/lint.sh`              | Lint the bundle (shellcheck, editorconfig)                |
| `ROADMAP.md`                 | Plan for the dev environment and the branch consolidation |

## TYPO3 instances

| Instance | TYPO3 | PHP | Extension branch              | Database | Console |
|----------|-------|-----|-------------------------------|----------|---------|
| v11      | 11.5  | 8.2 | `support/typo3-v11`           | `t3_v11` | 7.x (`typo3cms`) |
| v12      | 12.4  | 8.3 | `support/typo3-v12`           | `t3_v12` | 8.x     |
| v13      | 13.4  | 8.3 | `main`                        | `t3_v13` | 8.x/9.x |
| v14      | 14.3  | 8.4 | `feature/24-typo3-v14`        | `t3_v14` | 9.x     |
| v15      | 15.0.x-dev | 8.5 | `feature/116-typo3-v15`  | `t3_v15` | none    |

Each instance requires the extension from `packages/t3import_export` through a
symlinked path repository. The TYPO3 13 branch of the extension also requires
the core library `cpsit/import-export-core`; the v13 instance takes it from
`packages/import-export-core` in the same way, or from Packagist if the clone
is missing. The database connection is taken from the
environment variable `TYPO3_INSTANCE_DB` (see `instances/shared/development.php`).

The v14 and v15 instances require work branches of the extension with an
inline alias (`dev-feature/24-typo3-v14 as 4.0.x-dev`,
`dev-feature/116-typo3-v15 as 5.0.x-dev`), because no released version supports
these TYPO3 versions yet. TYPO3 15 is only available as development version
(`dev-main`, aliased `15.0.x-dev`). The v15 instance also requires:

* `cpsit/import-export-core` from `feature/60-symfony-8-v0.1` in
  `packages/import-export-core` (Symfony 8, core#60), checked out by `t3-switch 15`
* `dwenzel/t3extension-tools` from `feature/22-typo3-v15` on GitHub
  (TYPO3 15, typo3-console optional, t3extension_tools#22)

typo3-console has no version for TYPO3 15, so the v15 instance runs without it.
The extension's dev dependencies cannot be installed on TYPO3 15 yet
(see extension#116), so `ddev ext update` fails there.

Backend login for all instances: `admin` / `Password.1`.

TYPO3 11 and 12 are out of free support. Their last public releases depend on
packages with known security advisories, so `config.audit.block-insecure` is
disabled in these two instances. They are meant for local development only.

## Commands

| Command                         | Description                                                    |
|---------------------------------|----------------------------------------------------------------|
| `ddev ext-checkout [branch] [core-branch]` | Clone the extension and the core library, optionally check out branches of them |
| `ddev t3-switch [major]`        | Switch the active TYPO3 version, or list versions              |
| `ddev composer bundle:setup`    | Install TYPO3 in the active instance (idempotent)              |
| `ddev ext <composer args>`      | Run composer in `packages/t3import_export` (tests, linters)    |

## Testing the extension

`ddev ext` runs the extension's own composer scripts with the PHP version of the
active TYPO3 instance. Functional tests use the DDEV database server.

```bash
ddev ext update              # install the extension's dev dependencies (t3-switch does this)
ddev ext test:unit
ddev ext test:functional
ddev ext lint                # only on branches that define it
ddev ext sca
```

Run `ddev ext update` after checking out another extension branch without
`t3-switch` (or after `t3-switch --no-setup`): the branches use different
dependencies and build directories (`.Build/` vs. `.build/`, the same directory
on case-insensitive file systems such as macOS).

Composer fetches GitHub repositories via HTTPS, also when they are referenced by
an SSH URL. For private repositories, forward your SSH keys with `ddev auth ssh`
(needed again after `ddev poweroff`).

The support branches for TYPO3 11 and 12 get installable dev dependencies with
extension#57/#58 (`typo3/testing-framework` 7, PHPUnit 9.6); until those are
merged, `ddev ext update` fails there.

### File synchronisation

On macOS, DDEV uses Mutagen to synchronise the project between host and
container. Changes are synced with a short delay, in both directions. `ddev ext`
syncs before and after running composer. For other commands in the container
right after editing files on the host (e.g. `ddev exec`), run `ddev mutagen sync`
first. `Build/lint.sh` does not mount the project but streams the files into the
linter containers, for the same reason.

## Linting the bundle

```bash
Build/lint.sh
```

## Contributing

See [CONTRIBUTING.md](CONTRIBUTING.md) for the branching model and workflow,
and [ROADMAP.md](ROADMAP.md) for planned work.
