<?php

$app->notFound(function () use ($app) {
    $app->render('not-found.html.twig');
});

$app->error(function (\Exception $e) use ($app) {
    $app->render('error.html.twig');
});