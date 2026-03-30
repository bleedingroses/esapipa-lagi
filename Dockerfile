FROM php:8.3-cli

WORKDIR /app

# install dependencies system
RUN apt-get update && apt-get install -y \
    unzip \
    git \
    curl

# install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql

# install composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# copy project
COPY . .

# install Laravel dependencies
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# run app
CMD ["sh", "-c", "php artisan storage:link && sleep 20 && php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=$PORT"]