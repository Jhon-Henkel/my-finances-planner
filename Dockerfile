FROM composer AS composer-php

FROM php:8.2-apache

COPY . .

# copy composer
COPY --from=composer-php /usr/bin/composer /usr/bin/composer

# installing zip
RUN apt-get update && apt-get install -y zlib1g-dev libzip-dev unzip
RUN docker-php-ext-install zip

# instaling pdo
RUN docker-php-ext-install mysqli pdo pdo_mysql

# modifying apache
RUN a2enmod rewrite
RUN addgroup --gid 1000 appuser; \
    adduser --uid 1000 --gid 1000 --disabled-password appuser; \
    adduser www-data appuser; \
    sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf; \
    service apache2 restart;

# installing and setting xdbug
RUN pecl install xdebug \
    && echo "[XDEBUG]" > /usr/local/etc/php/conf.d/xdebug.ini \
        && echo "zend_extension=\"xdebug.so\"" >> /usr/local/etc/php/conf.d/xdebug.ini \
        && echo "xdebug.mode=coverage" >> /usr/local/etc/php/conf.d/xdebug.ini \
        && echo "xdebug.client_host = 127.0.0.1" >> /usr/local/etc/php/conf.d/xdebug.ini \
        && echo "xdebug.client_port = 9003" >> /usr/local/etc/php/conf.d/xdebug.ini \
        && echo "xdebug.start_with_request=trigger" >> /usr/local/etc/php/conf.d/xdebug.ini \