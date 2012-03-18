#!/bin/sh
if [ -d ./vendor ]; then
  rm -rf ./vendor
fi
mkdir ./vendor
curl http://silex.sensiolabs.org/get/silex.phar > ./vendor/silex.phar
git clone git://github.com/yuya-takeyama/timedtext.git ./vendor/timedtext
git clone git://github.com/fabpot/Twig.git ./vendor/twig
