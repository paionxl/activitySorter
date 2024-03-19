FROM php:8.0.0-fpm-alpine
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
RUN docker-php-ext-install pdo_mysql