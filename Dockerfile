# Stage 1: Build Frontend Assets (Vite)
FROM node:20-alpine AS frontend
WORKDIR /app
COPY package*.json ./
RUN npm ci || npm install
COPY . .
RUN npm run build

# Stage 2: Production PHP-FPM + Nginx (PHP 8.4)
FROM serversideup/php:8.4-fpm-nginx

# Switch to root to install PHP extensions and set permissions
USER root

# Install necessary extensions for Laravel, PostgreSQL, and Maatwebsite Excel
RUN install-php-extensions gd zip intl pdo_pgsql

# Copy application source code with proper ownership
COPY --chown=www-data:www-data . /var/www/html

# Copy compiled frontend assets from frontend stage
COPY --chown=www-data:www-data --from=frontend /app/public/build /var/www/html/public/build

# Ensure storage and bootstrap/cache permissions
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Switch to non-root user and pre-install Composer dependencies during build
USER www-data
RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader

# Expose internal Nginx port
EXPOSE 8080

# Built-in Laravel automations on container startup
ENV AUTORUN_ENABLED="true"
ENV AUTORUN_LARAVEL_MIGRATION="true"
ENV AUTORUN_LARAVEL_MIGRATION_FORCE="true"
ENV AUTORUN_LARAVEL_CONFIG_CACHE="true"
ENV AUTORUN_LARAVEL_ROUTE_CACHE="true"
ENV AUTORUN_LARAVEL_VIEW_CACHE="true"
