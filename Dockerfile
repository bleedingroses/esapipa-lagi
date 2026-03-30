FROM php:8.3-cli

WORKDIR /app
COPY . .

CMD ["sh", "-c", "sleep 20 && php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=$PORT"]