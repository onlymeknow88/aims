FROM php:8.1.14-fpm-alpine

LABEL maintainer="Hasan <github.com/koetik>"

WORKDIR /usr/src/app

RUN apk add --no-cache gcc musl-dev linux-headers pcre-dev zip libzip-dev ${PHPIZE_DEPS} && \
    curl -sS https://getcomposer.org/installer | php -- \
    --install-dir=/usr/bin --filename=composer && \
    docker-php-ext-configure zip && \
    docker-php-ext-install pdo_mysql mysqli zip && \
    pecl channel-update pecl.php.net && pecl install redis && \
    apk del pcre-dev ${PHPIZE_DEPS} && \
    docker-php-ext-enable redis

COPY docker_conf/php/php.ini /usr/local/etc/php/