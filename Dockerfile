# Base image FrankenPHP (Debian based)
FROM dunglas/frankenphp:latest

# Install system dependencies (Ubuntu/Debian)
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    libzip-dev \
    libpq-dev \
    libonig-dev \
    && docker-php-ext-install zip pdo pdo_mysql pdo_pgsql

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /app

# Copy project files
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Clear Laravel caches
RUN php artisan config:clear \
    && php artisan route:clear \
    && php artisan view:clear

# Cache Laravel configurations
RUN php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache

# Expose port used by FrankenPHP
EXPOSE 8080

# Run migrations then start server
CMD php artisan migrate --force && \
    frankenphp php-server --config=config/frankenphp.yaml
