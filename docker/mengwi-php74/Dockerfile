# PHP 7.4 for upkv2new (LPD Bali SIUPK Online).
# PHP 7.4 removed ext/mysql in 7.0, so we load the dshafik/php7-mysql-shim
# drop-in (mysqli-backed) via auto_prepend_file. Source is untouched.
FROM php:7.4-fpm

# bullseye-security moved to archive; pin apt to the 20221114 snapshot that
# matches this image so libpng/freetype versions still resolve.
RUN printf '%s\n' \
      'deb http://snapshot.debian.org/archive/debian/20221114T000000Z bullseye main' \
      'deb http://snapshot.debian.org/archive/debian-security/20221114T000000Z bullseye-security main' \
      > /etc/apt/sources.list \
    && echo 'Acquire::Check-Valid-Until "false";' > /etc/apt/apt.conf.d/10no-check-valid-until \
    && apt-get -o Acquire::AllowInsecureRepositories=true update

RUN apt-get -o Acquire::AllowInsecureRepositories=true update \
    && apt-get install -y --no-install-recommends --allow-unauthenticated \
        libfreetype6-dev libjpeg62-turbo-dev libpng-dev libzip-dev zip unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install mysqli gd zip \
    && rm -rf /var/lib/apt/lists/*

COPY mysql_shim.php /usr/local/lib/php/mysql_shim.php
RUN echo 'auto_prepend_file=/usr/local/lib/php/mysql_shim.php' > /usr/local/etc/php/conf.d/zz-mysql-shim.ini

WORKDIR /var/www/html
