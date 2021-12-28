FROM php:8.1-fpm-alpine

RUN pecl install xdebug && docker-php-ext-enable xdebug
RUN curl -s https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /app
