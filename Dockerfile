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

EXPOSE 8000

CMD ["/bin/sh", "-c", "cp .env.example .env && sed -i 's/DB_CONNECTION=mysql/DB_CONNECTION=pgsql/' .env && sed -i 's/DB_HOST=127.0.0.1/DB_HOST=aws-0-eu-west-1.pooler.supabase.com/' .env && sed -i 's/DB_PORT=3306/DB_PORT=5432/' .env && sed -i 's/DB_DATABASE=laravel/DB_DATABASE=postgres/' .env && sed -i 's/DB_USERNAME=root/DB_USERNAME=postgres.axvvbexlzzqxwustszwc/' .env && echo \"DB_PASSWORD=$DB_PASSWORD\" >> .env && php artisan key:generate && php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=8000"]