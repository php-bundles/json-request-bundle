FROM php:8.1-fpm-alpine

RUN curl -s https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN curl -s https://cs.symfony.com/download/php-cs-fixer-v3.phar -o /usr/local/bin/php-cs-fixer \
  && chmod +x /usr/local/bin/php-cs-fixer

WORKDIR /app
