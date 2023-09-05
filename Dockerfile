FROM php:8.1-apache

WORKDIR /var/www/html

RUN apt-get update -y && apt-get install -y libpng-dev libjpeg-dev

RUN docker-php-ext-install gd exif

RUN docker-php-ext-configure gd --with-jpeg && docker-php-ext-install -j$(nproc) gd

RUN chown -R www-data:www-data /var/www

RUN adduser --disabled-password --gecos '' developer

RUN chown -R developer:www-data /var/www

RUN chmod 755 /var/www

USER developer

COPY . .

EXPOSE 80
