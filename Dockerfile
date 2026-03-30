FROM php:8.3-cli

WORKDIR /app

# install system dependencies
RUN apt-get update && apt-get install -y \
    unzip \
    git \
    curl

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY . .

RUN composer install --no-interaction --prefer-dist --optimize-autoloader

CMD ["sh", "-c", "sleep 20 && php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=$PORT"]