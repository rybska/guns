<?php

use Silex\Application;
use Silex\Provider\AssetServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\HttpFragmentServiceProvider;
use Silex\Provider\DoctrineServiceProvider;

$app = new Application();
$app->register(new ServiceControllerServiceProvider());
$app->register(new AssetServiceProvider());
$app->register(new TwigServiceProvider());
$app->register(new HttpFragmentServiceProvider());
$app['twig'] = $app->extend('twig', function ($twig, $app) {
    // add custom globals, filters, tags, ...

    return $twig;
});

$app->register(
    new DoctrineServiceProvider(),
    [
        'db.options' => [
            'driver'    => 'pdo_mysql',
            'host'      => 'localhost',
            'dbname'    => 'register',
            'user'      => 'root',
            'password'  => '123',
            'charset'   => 'utf8',
            'driverOptions' => [
                1002 => 'SET NAMES utf8',
            ],
        ],
    ]
);
$app->register(new Silex\Provider\LocaleServiceProvider());
$app->register(new Silex\Provider\TranslationServiceProvider(), array(
    'locale_fallbacks' => array('en'),
));

$app->register(new Silex\Provider\FormServiceProvider());
$app->register(new Silex\Provider\ValidatorServiceProvider());
$app->register(new Silex\Provider\SecurityServiceProvider(), array(

));
$app['security.firewalls'] = array(
    'admin' => array(
        'pattern' => '^/admin/',
        'form' => array('login_path' => '/login', 'check_path' => '/admin/login_check'),
        'users' => array(
            'admin' => array('ROLE_ADMIN', '$2y$10$3i9/lVd8UOFIJ6PAMFt8gu3/r5g0qeCJvoSlLCsvMTythye19F77a'),
        ),
    ),
);
return $app;
