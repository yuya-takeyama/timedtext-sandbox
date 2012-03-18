#!/bin/sh
if [ ! -d ./vendor ]; then
  mkdir ./vendor
fi
curl http://silex.sensiolabs.org/get/silex.phar > ./vendor/silex.phar
git clone git://github.com/yuya-takeyama/timedtext.git ./vendor/timed-text
