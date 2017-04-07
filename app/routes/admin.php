<?php

$app->group('/admin', function () use ($app) {

    require 'admin/login.php';

    require 'admin/posts.php';

    require 'admin/users.php';

});