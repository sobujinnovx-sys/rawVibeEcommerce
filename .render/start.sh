#!/bin/sh
set -eu

cd /var/www/html

mkdir -p storage/framework/cache/data storage/framework/sessions storage/framework/views storage/logs
chown -R www-data:www-data storage bootstrap/cache

if [ -z "${DATABASE_URL:-}" ] && [ -z "${DB_HOST:-}" ]; then
  echo "Render database configuration is missing."
  echo "Use the Blueprint in render.yaml or set DATABASE_URL (preferred) or DB_HOST/DB_DATABASE/DB_USERNAME/DB_PASSWORD manually."
  exit 1
fi

if [ ! -L public/storage ]; then
  php artisan storage:link || true
fi

php artisan migrate --force

if [ "${APP_SEED_DEMO_DATA:-true}" = "true" ]; then
  php artisan db:seed --force
fi

php artisan config:cache
php artisan route:cache
php artisan view:cache

exec apache2-foreground