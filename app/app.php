<?php

if (session_status() == PHP_SESSION_NONE) {
    session_cache_limiter(false);
    session_start();
}

require '../vendor/autoload.php';

require 'middlewares/CheckAuthentication.php';
require 'lib/User.php';
require 'lib/Post.php';
require 'lib/DataBase.php';

$config = require 'config.php';

$app = new \Slim\Slim(array_merge([
    'view' => new \Slim\Views\Twig(),
    'templates.path' => __DIR__ . DIRECTORY_SEPARATOR . 'templates',
], $config));

// add middleware
$app->add(new CheckAuthentication());

$view = $app->view();
$view->parserExtensions = array(
    new \Slim\Views\TwigExtension(),
);

// add $app to twig variables in order to have access to flash messages
/** @var Twig_Environment $twig */
$twig = $view->getEnvironment();
$twig->addGlobal('app', $app);

// add routes
require 'routes/home.php';
require 'routes/admin.php';
require 'routes/error.php';

$app->run();