FROM php:7.4-fpm-alpine

RUN apk add --no-cache autoconf g++ make \
    && pecl install xdebug-3.0.2 \
    && rm -rf /tmp/pear \
    && docker-php-ext-enable xdebug

RUN apk add --no-cache postgresql-dev fcgi \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo_pgsql

RUN apk add --no-cache tzdata
ENV TZ Asia/Oral
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

RUN mv $PHP_INI_DIR/php.ini-production $PHP_INI_DIR/php.ini
COPY ./docker/common/php/conf.d /usr/local/etc/php/conf.d
COPY ./docker/common/php/php-fpm.d /usr/local/etc/php-fpm.d
COPY ./docker/production/php-fpm/conf.d /usr/local/etc/php/conf.d
COPY ./docker/production/php/conf.d /usr/local/etc/php/conf.d

RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql

RUN docker-php-ext-install pdo pdo_pgsql

WORKDIR /var/www

COPY ./ ./