# PHP 5.6 with the legacy ext/mysql (removed in PHP 7.0) compiled from source.
# appsbc1 (LPD Bali demo) uses mysql_connect/mysql_query throughout.
FROM php:5.6-fpm

# Debian stretch is archived: use archive.debian.org only (drop stretch-updates,
# security moves to stretch) and ignore expired Release signatures.
RUN echo "deb http://archive.debian.org/debian stretch main" > /etc/apt/sources.list \
    && apt-get -o Acquire::Check-Valid-Until=false \
       -o Acquire::AllowInsecureRepositories=true update

RUN docker-php-source extract \
    && docker-php-ext-install mysql mysqli \
    && docker-php-source delete

# Extensions used by the app (GD + zip)
RUN apt-get -o Acquire::Check-Valid-Until=false \
       -o Acquire::AllowInsecureRepositories=true update \
    && apt-get install -y --no-install-recommends --allow-unauthenticated \
        libfreetype6-dev libjpeg62-turbo-dev libpng-dev libzip-dev zip unzip \
    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install gd zip \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html
