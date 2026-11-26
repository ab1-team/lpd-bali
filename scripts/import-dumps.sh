#!/usr/bin/env bash
# Idempotent import of the LPD SQL dumps into the running lpd-db container.
# Run from the repo root: ./scripts/import-dumps.sh
set -euo pipefail

cd "$(dirname "$0")/.."

echo "==> Waiting for MySQL to accept connections"
for i in $(seq 1 30); do
    if docker exec lpd-db mysql -uroot -plpdroot2026 -e 'SELECT 1' >/dev/null 2>&1; then
        break
    fi
    sleep 2
done

echo "==> Creating auxiliary databases/users (idempotent)"
docker exec -i lpd-db mysql -uroot -plpdroot2026 < db/00_init.sql

for spec in \
    "lpdbalii_demo.sql:lpdbalii_demo" \
    "lpdbalii_siupkonline.sql:lpdbalii_siupkonline_baru"; do
    file="${spec%%:*}"
    db="${spec##*:}"
    echo "==> Importing $file -> $db (this can take several minutes)"
    docker exec -i lpd-db mysql -uroot -plpdroot2026 "$db" < "db/$file"
    count=$(docker exec lpd-db mysql -N -uroot -plpdroot2026 \
        -e "SELECT COUNT(*) FROM information_schema.tables WHERE table_schema='$db'")
    echo "    $db: $count tables"
done

echo "==> Grant app user access"
docker exec -i lpd-db mysql -uroot -plpdroot2026 <<'SQL'
CREATE USER IF NOT EXISTS 'lpdapp'@'%' IDENTIFIED BY 'lpdapp2026';
GRANT ALL PRIVILEGES ON lpdbalii_demo.* TO 'lpdapp'@'%';
GRANT ALL PRIVILEGES ON lpdbalii_siupkonline_baru.* TO 'lpdapp'@'%';
FLUSH PRIVILEGES;
SQL

echo "==> Import complete"
