FROM php:8.2-fpm-alpine

COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer

ENV PATH="/root/.composer/vendor/bin:$PATH"

RUN apk add --update --no-cache git

WORKDIR /app