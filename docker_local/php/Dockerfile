FROM php:8.3-cli

ARG COMPOSER_ALLOW_SUPERUSER=1

RUN apt-get update && apt-get install -y \
    curl \
    libzip-dev \
    libpq-dev \
    libonig-dev \
    libcurl4-openssl-dev \
    libfreetype6-dev \
    && docker-php-ext-install pdo zip pdo_pgsql curl opcache pcntl mbstring gd

RUN pecl install swoole \
    && docker-php-ext-enable swoole

RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

RUN touch /var/log/xdebug.log && \
    chmod 777 /var/log/xdebug.log

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY ./php.ini /usr/local/etc/php/conf.d/php.ini

WORKDIR /var/www/app

RUN chown -R 777 ./

CMD ["php", "artisan", "octane:start", "--host=0.0.0.0", "--port=8000", "--server=swoole"]

EXPOSE 8000
