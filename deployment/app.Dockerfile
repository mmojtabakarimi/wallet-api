FROM php:7.4.2-fpm-alpine

ARG XDEBUG_ENABLE=0
ENV COMPOSER_ALLOW_SUPERUSER=1
ENV PHP_OPCACHE_VALIDATE_TIMESTAMPS=0

RUN apk update && apk add libmcrypt-dev \
    mysql-client libzip-dev \
    libpng-dev nano bash \
    && docker-php-ext-install pdo_mysql zip bcmath opcache

# mcrypt, gd
RUN apk add --update --no-cache freetype-dev libjpeg-turbo-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd

RUN if [ $XDEBUG_ENABLE = "1" ]; then \
    apk add git build-base --no-cache --update --virtual buildDeps autoconf \
        && pecl install xdebug-2.9.2 \
        && docker-php-ext-enable xdebug; \
fi;

COPY deployment/php.ini /usr/local/etc/php/conf.d/custom.ini
COPY deployment/php-fpm.conf /usr/local/etc/php-fpm.d/www.conf

RUN apk add librdkafka-dev build-base --no-cache --update --virtual buildDeps autoconf
RUN pecl install rdkafka
RUN echo 'extension=rdkafka.so' >/usr/local/etc/php/conf.d/custom.ini

RUN curl -sS https://getcomposer.org/installer | php && mv composer.phar /usr/local/bin/composer

WORKDIR /var/www
COPY composer.json composer.lock /var/www/
RUN composer install --no-progress --no-autoloader

COPY app /var/www/app/
COPY bootstrap /var/www/bootstrap/
COPY config /var/www/config/
COPY deployment /var/www/deployment/
COPY database/ /var/www/database/
COPY public /var/www/public/
COPY resources /var/www/resources/
COPY routes /var/www/routes/
COPY storage /var/www/storage/
COPY tests /var/www/tests/
COPY artisan .env.example phpunit.xml /var/www/

RUN composer dump-autoload --optimize

CMD ["sh", "deployment/app.sh"]
