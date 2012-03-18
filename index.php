<?php
set_include_path(__DIR__ . '/vendor/timed-text/src' . PATH_SEPARATOR . get_include_path());
require_once __DIR__ . '/vendor/silex.phar';
require_once 'TimedText.php';

$app = new Silex\Application;

$app->get('/hello/{name}', function ($name) use ($app) {
    return "Hello, {$app->escape($name)}!";
});

$app->run();
