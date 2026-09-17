#!/bin/sh
set -e

# Generate APP_KEY if missing
if [ -z "$APP_KEY" ]; then
    php artisan key:generate --force || true
fi

# Cache optimizations
php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true

# Run migrations and seed database
php artisan migrate --force || true
php artisan db:seed --force || true

# Bind to Render / Cloud dynamic PORT
PORT_NUM=${PORT:-8080}
echo "Starting Laravel application on port $PORT_NUM..."
exec php artisan serve --host=0.0.0.0 --port=$PORT_NUM
