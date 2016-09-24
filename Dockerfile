FROM sillelien/base-alpine:0.10

MAINTAINER Yuya Takeyama <https://github.com/yuya-takeyama>

COPY rootfs /
COPY public /var/www
COPY views /var/views
COPY install-vendor.sh /var
COPY composer.json /var

RUN apk-install nginx \
  git \
  php-curl \
  php-dom \
  php-gd \
  php-fpm \
  php-json \
  php-phar \
  php-ctype \
  php-openssl && \
  php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
  php -r "if (hash_file('SHA384', 'composer-setup.php') === 'e115a8dc7871f15d853148a7fbac7da27d6c0030b848d9b3dc09e2a0388afed865e6a3d6b3c0fad45c48e2b5fc1196ae') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" && \
  php composer-setup.php --install-dir=/usr/bin --filename=composer && \
  php -r "unlink('composer-setup.php');" && \
  cd /var && \
  git config --global user.email "you@example.com" && \
  git config --global user.name "Your Name" && \
  sh install-vendor.sh

WORKDIR /var/www

EXPOSE 80
