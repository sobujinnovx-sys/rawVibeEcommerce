#!/bin/sh
set -eu

cd /var/www/html

mkdir -p storage/framework/cache/data storage/framework/sessions storage/framework/views storage/logs
chown -R www-data:www-data storage bootstrap/cache

if [ -z "${DATABASE_URL:-}" ] && [ -z "${DB_HOST:-}" ]; then
  echo "No external database configured. Falling back to SQLite for this deployment."
  export DB_CONNECTION=sqlite
  export DB_DATABASE=/var/www/html/database/database.sqlite
  mkdir -p /var/www/html/database
  touch /var/www/html/database/database.sqlite
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