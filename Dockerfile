FROM php:8.4-cli

WORKDIR /app

RUN apt-get update && apt-get install -y \
    git unzip curl libzip-dev zip \
    && docker-php-ext-install pdo pdo_mysql zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY . .

RUN composer install --no-dev --optimize-autoloader --no-scripts

RUN chmod -R 777 storage bootstrap/cache

# cài node
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

# build frontend
RUN npm install && npm run build

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]