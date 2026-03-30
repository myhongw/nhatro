FROM php:8.2-cli

# Cài extension cần thiết
RUN apt-get update && apt-get install -y \
    git unzip curl libzip-dev zip \
    && docker-php-ext-install pdo pdo_mysql zip

# Cài composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

# Copy source
COPY . .

# Cài vendor
RUN composer install

# chạy laravel
CMD php artisan serve --host=0.0.0.0 --port=8000