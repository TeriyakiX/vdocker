FROM php:8.1-fpm-alpine

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN apk update && apk add \
    build-base \
    nano \
    bash \
    curl

RUN curl -sSLf \
            -o /usr/local/bin/install-php-extensions \
            https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions

RUN chmod +x /usr/local/bin/install-php-extensions
RUN install-php-extensions \
    pdo \
    pdo_pgsql

COPY images/php.ini /usr/local/etc/php/conf.d/40-custom.ini

WORKDIR /var/www/html


CMD ["php-fpm"]