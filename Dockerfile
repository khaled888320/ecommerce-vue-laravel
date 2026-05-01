FROM php:8.2-cli

WORKDIR /app

RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    libpq-dev

RUN docker-php-ext-install pdo pdo_pgsql

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY . .

RUN composer install --no-dev --optimize-autoloader

COPY .env.example .env

RUN sed -i 's/DB_CONNECTION=mysql/DB_CONNECTION=pgsql/' .env

RUN php artisan key:generate

EXPOSE 8000

CMD ["/bin/sh", "-c", "php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=8000"]