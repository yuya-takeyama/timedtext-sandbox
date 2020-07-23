FROM php:7.4.8-apache

COPY public /var/www/html
COPY views /var/www/views
COPY install-vendor.sh /var/www
COPY composer.json /var/www
COPY composer.lock /var/www
COPY --from=composer /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

RUN a2enmod rewrite && \
  apt-get update && \
  apt-get install -y git libzip-dev && \
  docker-php-ext-install zip && \
  git config --global user.email "you@example.com" && \
  git config --global user.name "Your Name" && \
  ./install-vendor.sh

EXPOSE 80
