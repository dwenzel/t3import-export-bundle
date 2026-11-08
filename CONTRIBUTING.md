# Contributing

This repository contains the development environment for the TYPO3 extension
[Import & Export](https://github.com/dwenzel/t3import_export). Changes to the
extension itself are made in the extension repository; see its
[CONTRIBUTING.md](https://github.com/dwenzel/t3import_export/blob/main/CONTRIBUTING.md).

## Branching model

Both repositories follow the same branching model, which is adapted from
GitLab Flow.

* `main` is the only long-lived branch. It is protected: changes are integrated
  only through pull requests, and only after the automated checks have passed.
* There are no `develop` or `release/*` branches.
* All work (features, bugfixes, documentation) happens in feature branches
  created from `main`.

### Feature branches

Every change starts with a GitHub issue. Name the branch after the issue:

```
feature/{issue-number}-{title-in-kebab-case}
feature/{title-in-kebab-case}        # only if there is no issue
```

Examples: `feature/3-bundle-ci`, `feature/add-to-gitignore`

Branch names consist of lowercase alphanumeric characters and `-`. Other
characters (spaces, underscores, dots) are not allowed, apart from the `/`
after the prefix.

### Reserved names

| Name or prefix   | Use                                          |
|------------------|----------------------------------------------|
| `feature/`       | all regular work                             |
| `support/`       | support branches for older TYPO3 versions (extension only) |
| `environment/`   | automatically provisioned environments       |
| `hotfix/`        | reserved for future use                      |
| `renovate/`      | reserved for Renovate                        |
| `live`, `production`, `pre-production`, `staging`, `integration`, `hardening`, `acceptance` | reserved, do not use |

Former branches that should not be lost but are no longer maintained are kept
as tags under `archive/` (for example `archive/v13-bundle`).

## Workflow

1. Create or pick a GitHub issue.
2. Create a feature branch from the current `main`.
3. Make the change. Keep commits focused.
4. Run the checks locally (see below).
5. Open a pull request into `main`. Reference the issue (`Closes #12`).
6. The pull request is merged after the checks have passed and it has been reviewed.
7. Delete the feature branch after merging.

## Commit messages

Commit messages are short and start with one of these tags:

`[FEATURE]` `[TASK]` `[BUGFIX]` `[DOC]` `[CI]` `[DDEV]` `[SECURITY]` `[WIP]` `[DRAFT]`

Example: `[DDEV] Add PHP 8.4 to the web image`

`[WIP]` and `[DRAFT]` commits are not merged into `main`.

## Checks

```bash
Build/lint.sh                 # shellcheck and editorconfig (needs Docker)
```

The same checks run in GitHub Actions for every pull request (workflow `CI`).
For changes to instances or DDEV commands, also verify them in a running
environment, for each affected TYPO3 version:

```bash
ddev t3-switch 13             # likewise 11 and 12
ddev ext test:unit
```

## Releases

The bundle is not released or deployed; `main` is its current state.
