FROM dunglas/frankenphp

WORKDIR /app

COPY . .

RUN composer install --no-dev --optimize-autoloader

RUN php artisan config:clear && \
    php artisan route:clear && \
    php artisan view:clear

CMD php artisan serve --host 0.0.0.0 --port 8080
