#!/bin/sh
set -e

if [ ! -d "vendor" ]; then
    composer install --no-interaction --optimize-autoloader
fi

if [ ! -f ".env" ]; then
    cp .env.example .env
    php artisan key:generate
fi

if [ ! -f "storage/oauth-public.key" ] && [ -f "storage/oauth-private.key" ]; then
    chmod -R 775 storage bootstrap/cache
fi

chown -R www:www /var/www/storage /var/www/bootstrap/cache 2>/dev/null || true

exec "$@"
