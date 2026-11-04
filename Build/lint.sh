#!/usr/bin/env bash
# Lint the bundle itself: shell scripts (shellcheck) and editorconfig rules.
# Runs the linters in Docker, so no host installation is needed.

set -euo pipefail

root="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
cd "${root}"

list_scripts() {
    # Collect shell scripts: DDEV custom commands and Build/*.sh
    find .ddev/commands -type f ! -name '*.md' ! -name '.gitattributes' -path '*/commands/*/*' 2>/dev/null
    find Build tests -type f -name '*.sh' 2>/dev/null || true
}

scripts=()
while IFS= read -r file; do
    scripts+=("${file}")
done < <(list_scripts | sort)

echo "shellcheck: ${#scripts[@]} file(s)"
docker run --rm -v "${root}:/mnt:ro" -w /mnt koalaman/shellcheck:v0.10.0 -x "${scripts[@]}"

echo "editorconfig-checker"
docker run --rm -v "${root}:/check:ro" -w /check mstruebing/editorconfig-checker:v3.0.3 \
    ec -exclude '^(LICENSE|packages/|instances/[^/]+/(vendor|public|var)/|\.git/)'

echo "OK"
