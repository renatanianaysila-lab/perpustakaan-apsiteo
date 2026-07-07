#!/bin/sh
set -e

# Copy .env if it doesn't exist
if [ ! -f "/var/www/html/.env" ]; then
    echo "Creating .env file..."
    cp /var/www/html/.env.example /var/www/html/.env
fi

# Ensure APP_KEY is generated if not set
if ! grep -q "APP_KEY=base64:" /var/www/html/.env; then
    echo "Generating Application Key..."
    php artisan key:generate --force
fi

# Initialize SQLite database if connection is sqlite
DB_CONN=$(grep "^DB_CONNECTION=" /var/www/html/.env | cut -d '=' -f2)
# Standard Laravel 11/12 database path is database/database.sqlite
DB_PATH="/var/www/html/database/database.sqlite"
if [ "$DB_CONN" = "sqlite" ] || [ -z "$DB_CONN" ]; then
    if [ ! -f "$DB_PATH" ]; then
        echo "Creating SQLite database file at $DB_PATH..."
        touch "$DB_PATH"
    fi
fi

# Ensure directories exist and are writable
mkdir -p /var/www/html/storage/framework/cache/data
mkdir -p /var/www/html/storage/framework/sessions
mkdir -p /var/www/html/storage/framework/views
mkdir -p /var/www/html/storage/logs
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/database

# Run migrations
echo "Running migrations..."
php artisan migrate --force

# Optimize Laravel cache for production
echo "Optimizing Laravel cache..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Execute the container's main command
echo "Starting web server..."
exec "$@"
