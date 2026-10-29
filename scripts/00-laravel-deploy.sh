#!/usr/bin/env bash
echo "==> Running Composer install..."
composer install --no-dev --optimize-autoloader --no-interaction

echo "==> Caching Laravel configuration..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "==> Running database migrations..."
php artisan migrate --force

echo "==> Laravel deployment preparation complete!"
