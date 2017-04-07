<?php

$app->get('/posts', function () use ($app) {
    $userId = $app->container->get('user')->getId();

    if ($userId == 1) {
        $userId = null;
    }

    $app->render('admin/posts/list.html.twig', [
        'posts' => Post::getAll($userId),
    ]);
})->name('admin.posts');

$app->get('/posts/add', function () use ($app) {
    $twigVars = [];

    if (!empty($_SESSION['postsFormData'])) {
        $twigVars['formData'] = $_SESSION['postsFormData'];

        unset($_SESSION['postsFormData']);
    }

    $app->render('admin/posts/add.html.twig', $twigVars);
})->name('admin.posts.add');

$app->post('/posts/add', function () use ($app) {
    $postData = [
        'title' => $app->request->post('title'),
        'text' => $app->request->post('text'),
    ];

    $result = Post::validate($postData);

    if (count($result['errors']) > 0) {
        $_SESSION['postsFormData'] = $result;

        $app->redirectTo('admin.posts.add');
    }

    $postData['user_id'] = $app->container->get('user')->getId();

    Post::insert($postData);

    $app->flash('success', 'Post was added successfully');
    $app->redirectTo('admin.posts');
})->name('admin.posts.add.post');

$app->get('/posts/edit/:postId', function ($postId) use ($app) {
    $post = getPostInstance($postId);

    $twigVars = [];

    if (!empty($_SESSION['postsFormData'])) {
        $twigVars['formData'] = $_SESSION['postsFormData'];

        unset($_SESSION['postsFormData']);
    } else {
        $postData = $post->toArray();

        $twigVars['formData'] = ['values' => $postData];
    }

    $app->render('admin/posts/edit.html.twig', $twigVars);
})->name('admin.posts.edit')->conditions(['postId' => '\d+']);

$app->post('/posts/edit/:postId', function ($postId) use ($app) {
    $post = getPostInstance($postId);

    $newPostData = [
        'title' => $app->request->post('title'),
        'text' => $app->request->post('text'),
    ];

    $result = Post::validate($newPostData);

    if (count($result['errors']) > 0) {
        $_SESSION['postsFormData'] = $result;

        $app->redirectTo('admin.posts.edit', ['postId' => $postId]);
    }

    $post->update($newPostData);

    $app->flash('success', 'Post was updated successfully');
    $app->redirectTo('admin.posts');
})->name('admin.posts.edit.post')->conditions(['postId' => '\d+']);

$app->get('/posts/delete/:postId', function ($postId) use ($app) {
    $post = getPostInstance($postId);
    $postData = $post->toArray();

    $app->render('admin/posts/delete.html.twig', [
        'post' => $postData,
    ]);
})->name('admin.posts.delete')->conditions(['postId' => '\d+']);

$app->post('/posts/delete/:postId', function ($postId) use ($app) {
    $post = getPostInstance($postId);
    $post->delete();

    $app->flash('success', 'Post was deleted successfully');
    $app->redirectTo('admin.posts');
})->name('admin.posts.delete.post')->conditions(['postId' => '\d+']);

/**
 * Validate passed post and get post object instance
 *
 * @param $postId
 * @return Post
 */
function getPostInstance($postId)
{
    $app = \Slim\Slim::getInstance();

    if (Post::isValid($postId) == false) {
        $app->flash('danger', 'Invalid post');
        $app->redirectTo('admin.posts');
    }

    $post = new Post($postId);
    $postData = $post->toArray();

    $loggedUserId = $app->container->get('user')->getId();

    if ($loggedUserId != 1 && $postData['user_id'] != $loggedUserId) {
        $app->flash('danger', 'Invalid post');
        $app->redirectTo('admin.posts');
    }

    return $post;
}
