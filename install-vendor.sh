#!/bin/sh
composer install
if [ ! -d ./vendor ]; then
  mkdir ./vendor
fi
if [ ! -d ./vendor/timedtext ]; then
  git clone git://github.com/yuya-takeyama/timedtext.git ./vendor/timedtext
fi
cd ./vendor/timedtext && git pull origin master
