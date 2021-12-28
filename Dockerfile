FROM php:7.4-fpm-alpine

ENV COMPOSER_ALLOW_SUPERUSER 1

RUN apk add git build-base php7-dev
RUN pecl -q install xdebug && docker-php-ext-enable xdebug
RUN curl -s https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /app
