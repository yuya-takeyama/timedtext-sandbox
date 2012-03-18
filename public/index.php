<?php
set_include_path(__DIR__ . '/../vendor/timedtext/src' . PATH_SEPARATOR . get_include_path());
require_once __DIR__ . '/../vendor/silex.phar';
require_once 'TimedText.php';

use \Symfony\Component\HttpFoundation\Response;
use \Symfony\Component\HttpFoundation\Cookie;

define('DEFAULT_TEXT', <<<__TEXT__
{before 2012-03-18 00:00}
この文字列は 2012-03-18 00:00 まで表示されます.
{/before}
この文字列は常に表示されます.
{after 2012-03-20 00:00}
この文字列は 2012-03-20 00:00 以降に表示されます.
{/after}
__TEXT__
);

$app = new Silex\Application;
$app['debug'] = true;
$app->register(new Silex\Provider\TwigServiceProvider, array(
    'twig.path'       => __DIR__ . '/../views',
    'twig.class_path' => __DIR__ . '/../vendor/twig/lib',
));

$app->before(function () use ($app) {
    $app->response = new Response;
    $app['twig']->addGlobal('layout', $app['twig']->loadTemplate('layout.twig'));
    if (! $app['request']->cookies->has('text')) {
        $app->response->headers->setCookie(new Cookie('text', DEFAULT_TEXT));
        $app->text = DEFAULT_TEXT;
    } else {
        $app->text = $app['request']->cookies->get('text');
    }
});

$app->get('/text', function () use ($app) {
    $datetime = new DateTime;
    $app->response->setContent(
        $app['twig']->render('text.twig', array(
            'text'       => $app->text,
            'cur_year'   => (int)$datetime->format('Y'),
            'cur_month'  => (int)$datetime->format('n'),
            'cur_day'    => (int)$datetime->format('j'),
            'cur_hour'   => (int)$datetime->format('G'),
            'cur_minute' => (int)$datetime->format('i'),
        ))
    );
    return $app->response;
});

$app->post('/text', function () use ($app) {
    $app->response->headers->setCookie(new Cookie('text', $app['request']->get('text')));
    $app->response->setStatusCode(302);
    $app->response->headers->set('Location', '/text');
    return $app->response;
});

$app->post('/preview', function () use ($app) {
    $app->response->setContent(
        $app['twig']->render('preview.twig', array(
            'raw_text'       => $app['request']->get('text'),
            'converted_text' => TimedText::convert($app['request']->get('text')),
            'date_format'    => 'Y/m/d (D) H:i',
        ))
    );
    return $app->response;
});

$app->post('/preview-at-time', function () use ($app) {
    $datetime = new DateTime;
    $req = $app['request'];
    $datetime->setDate($req->get('year'), $req->get('month'), $req->get('day'));
    $datetime->setTime($req->get('hour'), $req->get('minute'));
    $app->response->setContent(
        $app['twig']->render('preview-at-time.twig', array(
            'raw_text'       => $req->get('text'),
            'converted_text' => TimedText::convert($req->get('text'))->at($datetime->getTimestamp()),
            'datetime'       => $datetime,
            'date_format'    => 'Y/m/d (D) H:i',
        ))
    );
    return $app->response;
});

$app->get('/', function () use ($app) {
    $app->response->setContent(
        $app['twig']->render('index.twig', array(
            'raw_text'       => $app->text,
            'converted_text' => TimedText::convert($app->text),
        ))
    );
    return $app->response;
});

$app->run();
