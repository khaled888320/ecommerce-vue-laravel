FROM php:8.2-cli

WORKDIR /app

RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    libsqlite3-dev

RUN docker-php-ext-install pdo pdo_sqlite

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY . .

RUN composer install --no-dev --optimize-autoloader

COPY .env.example .env

RUN php artisan key:generate

RUN touch database/database.sqlite

EXPOSE 8000

CMD ["/bin/sh", "-c", "php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=8000"]