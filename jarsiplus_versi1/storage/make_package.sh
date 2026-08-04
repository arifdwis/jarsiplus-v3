#!/bin/bash
set -e

echo "=== 1. Dumping Database ==="
mysqldump --no-tablespaces --single-transaction --quick -u jarisplus_root -p'y8nXea9lDYSz@' jarsiplus_main > /var/www/html/jarsiplus/database_dump.sql
echo "Database dumped successfully."

echo "=== 2. Preparing Staging Directory ==="
STAGING="/tmp/jarsiplus_package"
rm -rf "$STAGING"
mkdir -p "$STAGING"

echo "=== 3. Copying Files (Excluding vendor, node_modules, storage uploads) ==="
rsync -av \
  --exclude='vendor/' \
  --exclude='node_modules/' \
  --exclude='.git/' \
  --exclude='storage/app/public/*' \
  --exclude='storage/jarsiplus/*' \
  --exclude='storage/framework/cache/data/*' \
  --exclude='storage/framework/sessions/*' \
  --exclude='storage/framework/views/*' \
  --exclude='storage/logs/*' \
  --exclude='public_html/storage/*' \
  --exclude='public_html/storage' \
  --exclude='jarsiplus_app_update.zip' \
  --exclude='tmp/' \
  --exclude='access-logs/' \
  --exclude='error_log' \
  --exclude='perl5/' \
  --exclude='ssl/' \
  --exclude='public_ftp/' \
  --exclude='www' \
  /var/www/html/jarsiplus/ "$STAGING/"

echo "=== 4. Preserving Storage Directory Structure ==="
mkdir -p "$STAGING/storage/app/public/sikerja/permohonan/file"
mkdir -p "$STAGING/storage/app/public/jarsiplus/inovasi/file"
mkdir -p "$STAGING/storage/framework/cache/data"
mkdir -p "$STAGING/storage/framework/sessions"
mkdir -p "$STAGING/storage/framework/views"
mkdir -p "$STAGING/storage/logs"

touch "$STAGING/storage/app/public/.gitkeep"
touch "$STAGING/storage/framework/cache/.gitkeep"
touch "$STAGING/storage/framework/sessions/.gitkeep"
touch "$STAGING/storage/framework/views/.gitkeep"
touch "$STAGING/storage/logs/.gitkeep"

if [ -d "$STAGING/public_html" ]; then
    cd "$STAGING/public_html"
    ln -sf ../storage/app/public storage
    cd "$STAGING"
fi

echo "=== 5. Creating ZIP Package ==="
cd "$STAGING"
zip -r /var/www/html/jarsiplus/jarsiplus_app_update.zip .

echo "=== 6. Cleanup Staging ==="
rm -rf "$STAGING"

echo "=== SUCCESS! Package created at /var/www/html/jarsiplus/jarsiplus_app_update.zip ==="
