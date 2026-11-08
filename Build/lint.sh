#!/usr/bin/env bash
# Lint the bundle itself: shell scripts (shellcheck) and editorconfig rules.
# Runs the linters in Docker, so no host installation is needed.

set -euo pipefail

root="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
cd "${root}"

list_scripts() {
    # Collect shell scripts: DDEV custom commands, instance helpers, Build/*.sh
    find .ddev/commands -type f ! -name '*.md' ! -name '*.txt' ! -name '.gitattributes' -path '*/commands/*/*' 2>/dev/null
    find instances/shared/bin -type f 2>/dev/null
    find Build tests -type f -name '*.sh' 2>/dev/null || true
}

scripts=()
while IFS= read -r file; do
    scripts+=("${file}")
done < <(list_scripts | sort)

# The files are streamed into the containers with tar instead of bind-mounting the
# project: bind mounts (Docker Desktop file sharing) sometimes return the previous
# content of a file that was just changed on the host.
# COPYFILE_DISABLE: no macOS metadata files (._*) in the archive.
export COPYFILE_DISABLE=1

echo "shellcheck: ${#scripts[@]} file(s)"
tar -cf - "${scripts[@]}" | docker run --rm -i --entrypoint sh koalaman/shellcheck-alpine:v0.10.0 \
    -c 'mkdir -p /src && cd /src && tar -xf - && shellcheck -x "$@"' sh "${scripts[@]}"

echo "editorconfig-checker"
git ls-files -z --cached --others --exclude-standard -- . ':!packages' ':!LICENSE' |
    tar --null -T - -cf - |
    docker run --rm -i --entrypoint sh mstruebing/editorconfig-checker:v3.0.3 \
        -c 'mkdir -p /check && cd /check && tar -xf - && ec'

echo "OK"
