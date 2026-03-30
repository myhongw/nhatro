FROM php:8.4-cli

WORKDIR /app

RUN apt-get update && apt-get install -y \
    unzip curl \
    && docker-php-ext-install pdo pdo_mysql

COPY . .

CMD php artisan serve --host=0.0.0.0 --port=8000