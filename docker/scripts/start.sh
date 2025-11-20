#!/usr/bin/env bash
 
set -e

role=${CONTAINER_ROLE:-app}
env=${APP_ENV:-production}

chown -R www-data:www-data /var/www/html
chmod -R 775 /var/www/html/storage
chmod -R 775 /var/www/html/bootstrap/cache

if [ ! -d "/var/www/html/vendor" ]; then
    composer install --no-interaction --no-progress
fi

if [ -f "/var/www/html/.env" ]; then
    if ! grep -q "^APP_KEY=" .env || grep -q "^APP_KEY=$" .env; then
        php artisan key:generate
    fi
fi

if [ "${RUN_MIGRATIONS:-false}" = "true" ]; then
    php artisan migrate --force
fi

if [ "$env" != "local" ]; then
    echo "Caching configuration..."
    (cd /var/www/html && 
    php artisan optimize  && 
    php artisan filament:optimize  && 
    php artisan config:cache &&
    php artisan route:cache &&
    php artisan view:cache)
fi


if [ "$role" = "app" ]; then
 
    exec apache2-foreground
 
elif [ "$role" = "queue" ]; then
 
    echo "Running the queue..."
    php /var/www/html/artisan queue:work --verbose --tries=3 --timeout=90
 
elif [ "$role" = "scheduler" ]; then
 
    echo "Scheduler role"
    exit 1
 
else
    echo "Could not match the container role \"$role\""
    exit 1
fi