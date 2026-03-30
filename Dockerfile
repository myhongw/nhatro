FROM php:8.4-fpm

WORKDIR /app

COPY . .

RUN apt-get update && apt-get install -y \
    git unzip curl

# cài composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 🔥 QUAN TRỌNG
RUN composer install --no-dev --optimize-autoloader

CMD ["php-fpm"]