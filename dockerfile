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

# Установка Swoole
RUN pecl install swoole \
    && docker-php-ext-enable swoole

RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

RUN touch /var/log/xdebug.log && \
    chmod 777 /var/log/xdebug.log

# Установка Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY ./docker_local/php/php.ini /usr/local/etc/php/conf.d/php.ini

# Установка рабочего каталога
WORKDIR /var/www/app
COPY . .
# Настройка прав доступа (если необходимо)
RUN chown -R 777 ./

RUN composer install && php artisan key:generate

# Запуск Laravel Octane с Open Swoole
CMD ["php", "artisan", "octane:start", "--host=0.0.0.0", "--port=8000", "--server=swoole"]

# Открываем порт для доступа
EXPOSE 8000
