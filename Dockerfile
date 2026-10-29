# Stage 1: Build Frontend Assets (Vite)
FROM node:20-alpine AS frontend
WORKDIR /app
COPY package*.json ./
RUN npm ci || npm install
COPY . .
RUN npm run build

# Stage 2: Production PHP-FPM + Nginx (Render official recommendation)
FROM richarvey/nginx-php-fpm:3.1.6

WORKDIR /var/www/html

# Copy application source code
COPY . .

# Copy compiled frontend assets from frontend stage
COPY --from=frontend /app/public/build ./public/build

# Container configuration for Render & Laravel
ENV SKIP_COMPOSER 1
ENV WEBROOT /var/www/html/public
ENV PHP_ERRORS_STDERR 1
ENV RUN_SCRIPTS 1
ENV REAL_IP_HEADER 1
ENV COMPOSER_ALLOW_SUPERUSER 1

# Ensure deployment script has executable permissions inside the container
RUN chmod +x /var/www/html/scripts/00-laravel-deploy.sh

CMD ["/start.sh"]
