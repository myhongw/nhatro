FROM php:8.2-cli

WORKDIR /app

# Cài thư viện cần thiết
RUN apt-get update && apt-get install -y \
    git unzip curl libzip-dev zip \
    && docker-php-ext-install pdo pdo_mysql

# Cài composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy source
COPY . .

# Cài Laravel
RUN composer install --no-dev --optimize-autoloader

# Fix quyền
RUN chmod -R 777 storage bootstrap/cache

# Chạy Laravel
CMD php artisan serve --host=0.0.0.0 --port=8000