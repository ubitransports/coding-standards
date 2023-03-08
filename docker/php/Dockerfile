FROM php:7.4-fpm-alpine

COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer

ENV PATH="/root/.composer/vendor/bin:$PATH"

WORKDIR /app