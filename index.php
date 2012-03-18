<?php
set_include_path(__DIR__ . '/vendor/timed-text/src' . PATH_SEPARATOR . get_include_path());
require_once __DIR__ . '/vendor/silex.phar';
require_once 'TimedText.php';

$app = new Silex\Application;
$app->register(new Silex\Provider\TwigServiceProvider, array(
    'twig.path'       => __DIR__ . '/views',
    'twig.class_path' => __DIR__ . '/vendor/twig/lib',
));

$app->before(function () use ($app) {
    $app['twig']->addGlobal('layout', $app['twig']->loadTemplate('layout.twig'));
});

$app->get('/', function () use ($app) {
    return $app['twig']->render('index.twig');
});

$app->run();
