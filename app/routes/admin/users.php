<?php

$app->get('/users', function () use ($app) {
    $app->render('admin/users/list.html.twig', [
        'users' => User::getAll(),
    ]);
})->name('admin.users');

$app->get('/users/add', function () use ($app) {
    $twigVars = [];

    if (!empty($_SESSION['usersFormData'])) {
        $twigVars['formData'] = $_SESSION['usersFormData'];

        unset($_SESSION['usersFormData']);
    }

    $app->render('admin/users/add.html.twig', $twigVars);
})->name('admin.users.add');

$app->post('/users/add', function () use ($app) {
    $userData = [
        'username' => $app->request->post('username'),
        'password' => $app->request->post('password'),
        'password2' => $app->request->post('password2'),
        'name' => $app->request->post('name'),
    ];

    $result = User::validate($userData);

    if (count($result['errors']) > 0) {
        $_SESSION['usersFormData'] = $result;

        $app->redirectTo('admin.users.add');
    }

    unset($userData['password2']);

    User::insert($userData);

    $app->flash('success', 'User was added successfully');
    $app->redirectTo('admin.users');
})->name('admin.users.add.post');

$app->get('/users/edit/:userId', function ($userId) use ($app) {
    $user = getUserInstance($userId);

    $twigVars = [];

    if (!empty($_SESSION['usersFormData'])) {
        $twigVars['formData'] = $_SESSION['usersFormData'];

        unset($_SESSION['usersFormData']);
    } else {
        $userData = $user->toArray();

        unset($userData['password']);

        $twigVars['formData'] = ['values' => $userData];
    }

    $app->render('admin/users/edit.html.twig', $twigVars);
})->name('admin.users.edit')->conditions(['userId' => '\d+']);

$app->post('/users/edit/:userId', function ($userId) use ($app) {
    $user = getUserInstance($userId);

    $newUserData = [
        'username' => $app->request->post('username'),
        'name' => $app->request->post('name'),
        'userId' => $userId,
    ];

    // update the password only if new password is submitted
    $password = $app->request->post('password');

    if ($password !== '') {
        $newUserData['password'] = $password;
        $newUserData['password2'] = $app->request->post('password2');
    }

    $result = User::validate($newUserData);

    if (count($result['errors']) > 0) {
        $_SESSION['usersFormData'] = $result;

        $app->redirectTo('admin.users.edit', ['userId' => $userId]);
    }

    unset($newUserData['password2']);
    unset($newUserData['userId']);

    $user->update($newUserData);

    $app->flash('success', 'User was updated successfully');
    $app->redirectTo('admin.users');
})->name('admin.users.edit.post')->conditions(['userId' => '\d+']);

$app->get('/users/delete/:userId', function ($userId) use ($app) {
    $user = getUserInstance($userId);
    $userData = $user->toArray();

    $app->render('admin/users/delete.html.twig', [
        'user' => $userData,
    ]);
})->name('admin.users.delete')->conditions(['userId' => '\d+']);

$app->post('/users/delete/:userId', function ($userId) use ($app) {
    $user = getUserInstance($userId);
    $user->delete();

    $app->flash('success', 'User was deleted successfully');
    $app->redirectTo('admin.users');
})->name('admin.users.delete.post')->conditions(['userId' => '\d+']);

/**
 * Validate passed user and get user object instance
 *
 * @param $userId
 * @return User
 */
function getUserInstance($userId)
{
    $app = \Slim\Slim::getInstance();

    if ($userId == 1 || User::isValid($userId) == false) {
        $app->flash('danger', 'Invalid user');
        $app->redirectTo('admin.users');
    }

    $user = new User($userId);

    return $user;
}
