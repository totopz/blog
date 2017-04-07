<?php

$app->get('/(:page)', function ($page = null) use ($app) {
    if ($page == null) {
        $page = 1;
    }

    $postsCount = Post::getPostsCount();
    $postsPerPage = $app->config('postsPerPage');
    $pagesCount = ceil($postsCount / $postsPerPage);

    if ($page > $pagesCount) {
        $page = $pagesCount;
    }

    $app->render('home/list.html.twig', [
        'posts' => Post::getPosts($page, $postsPerPage),
        'page' => $page,
        'pagesCount' => $pagesCount,
    ]);
})->name('home')->conditions(['page' => '\d+']);

$app->get('/post/:postId', function ($postId) use ($app) {
    if (Post::isValid($postId) == false) {
        $app->flash('danger', 'Invalid post');
        $app->redirectTo('home');
    }

    $post = new Post($postId);
    $postData = $post->toArray();

    $user = new User($postData['user_id']);
    $userData = $user->toArray();

    $app->render('home/post.html.twig', [
        'post' => $postData,
        'user' => $userData,
    ]);
}) ->name('home.post')->conditions(['postId' => '\d+']);