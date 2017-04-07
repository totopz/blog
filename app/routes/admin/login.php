<?php

$app->get('/login', function () use ($app) {
    $app->render('admin/login/login.html.twig', [

    ]);
})->name('admin.login');

$app->post('/login', function () use ($app) {
    $username = $app->request->post('username');
    $password = $app->request->post('password');

    try {
        $result = User::login($username, $password);
    } catch (\InvalidArgumentException $e) {
        $app->flash('danger', 'Please fill username and password fields');
        $app->redirectTo('admin.login');
        exit; // just to silence PHPStorm notice on $result variable
    }

    if ($result === false) {
        $app->flash('danger', 'Invalid username or password');
        $app->redirectTo('admin.login');
    }

    $_SESSION['userId'] = $result->getId();

    $app->redirectTo('admin.posts');
})->name('admin.login.post');

$app->get('/logout', function () use ($app) {
    unset($_SESSION['userId']);
    $app->redirectTo('admin.login');
})->name('admin.logout');