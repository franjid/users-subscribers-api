FROM php:8.2-fpm-alpine

RUN apk add --update \
    composer \
    rabbitmq-c-dev \
    icu-dev \
    linux-headers \
    && rm -rf /var/cache/apk/*

RUN apk add --no-cache --virtual .phpize-deps $PHPIZE_DEPS \
    && pecl install amqp \
    && docker-php-ext-enable amqp \
    && docker-php-ext-install sockets \
    && docker-php-ext-install bcmath \
    && docker-php-ext-install intl \
    && docker-php-ext-install pdo \
    && docker-php-ext-install pdo_mysql

WORKDIR /code/api

COPY ./code/api/composer.json ./code/api/composer.lock /code/api/
RUN composer install \
    --ignore-platform-req=ext-sockets \
    --ignore-platform-req=ext-amqp \
    --ignore-platform-req=ext-pdo \
    --ignore-platform-req=ext-tokenizer \
    --ignore-platform-req=ext-xml \
    --ignore-platform-req=ext-xmlwriter \
    --ignore-platform-req=ext-dom \
    --ignore-platform-req=ext-ctype

COPY ./docker/php/php.ini /usr/local/etc/php/conf.d/custom.ini
