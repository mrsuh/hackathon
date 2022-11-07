FROM php:7.0-cli as build

RUN echo 'memory_limit=512M' >> /usr/local/etc/php/conf.d/docker-php-memlimit.ini

COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/bin/

RUN apt-get update && apt-get upgrade -y \
    netcat \
    git \
    libzip-dev \
    unzip

RUN install-php-extensions \
    intl \
    iconv \
    mbstring \
    zip \
    bcmath \
    pdo_mysql \
    mysqli \
    pcntl

COPY --from=composer:2.2 /usr/bin/composer /usr/bin/composer

COPY . /app

RUN cp /app/docker/php/parameters.yml /app/app/config/parameters.yml

RUN groupadd -r docker && useradd -m -g docker docker

RUN chown -R docker /app

USER docker

WORKDIR /app

RUN composer install
