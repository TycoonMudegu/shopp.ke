#!/usr/bin/env bash
set -euo pipefail

if [[ "${EUID}" -ne 0 ]]; then
    printf 'Run this script with sudo.\n' >&2
    exit 1
fi

config_dir="$(cd -- "$(dirname -- "${BASH_SOURCE[0]}")" && pwd)"
project_dir="$(cd -- "$config_dir/../.." && pwd)"
install -d -m 770 -g www-data "$project_dir/storage"
localhost_path="$(dirname -- "$project_dir")/shopp.ke"

if [[ ! -e "$localhost_path" && ! -L "$localhost_path" ]]; then
    ln -s "$project_dir/public" "$localhost_path"
elif [[ "$(readlink -f -- "$localhost_path")" != "$project_dir/public" ]]; then
    printf 'Cannot configure %s: another file or directory already exists there.\n' "$localhost_path" >&2
    exit 1
fi

install -m 644 "$config_dir/shopp.test.conf" /etc/apache2/sites-available/shopp.test.conf
a2enmod rewrite
a2ensite shopp.test.conf
apache2ctl configtest
service apache2 reload

if ! awk '{ sub(/#.*/, ""); for (i = 2; i <= NF; i++) if ($i == "shopp.test") found = 1 } END { exit !found }' /etc/hosts; then
    printf '\n127.0.0.1\tshopp.test\n' >> /etc/hosts
fi

printf '\nOpen http://shopp.localhost/ in your browser.\n'
printf 'http://localhost/shopp.ke redirects to the same site.\n'
printf 'http://shopp.test/ is also available inside WSL.\n'
