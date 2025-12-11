# Use the official FrankenPHP image with FPM + Caddy
FROM dunglas/frankenphp:1.1.3-php8.2

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git unzip curl libzip-dev libpq-dev libonig-dev \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql zip

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set working dir
WORKDIR /app

# Copy app files
COPY . .

# Install dependencies
RUN composer install --no-dev --optimize-autoloader

# Laravel cache
RUN php artisan config:clear \
 && php artisan route:clear \
 && php artisan view:clear \
 && php artisan config:cache \
 && php artisan route:cache \
 && php artisan view:cache

# Expose FrankenPHP port
EXPOSE 8080

# Start command
CMD php artisan migrate --force && \
    frankenphp php-server --config=frankenphp.yaml

