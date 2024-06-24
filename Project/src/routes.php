<?php
    return [
        '/^hello\/(.*)$/' => [\Controllers\MainController::class, 'sayHello'],
        '/^$/' => [\Controllers\MainController::class, 'main'],

        '/articles/' => [\Controllers\ArticleController::class, 'index'],
        '/^article$/' => [\Controllers\ArticleController::class, 'create'],
        '~^article/(\d+)$~' => [\Controllers\ArticleController::class, 'show'],
        '~^article/edit/(\d+)$~' => [\Controllers\ArticleController::class, 'edit'],
        '~^article/update/(\d+)$~' => [\Controllers\ArticleController::class, 'update'],
        '~^article/delete/(\d+)$~' => [\Controllers\ArticleController::class, 'delete'],
        '~^article/create$~' => [\Controllers\ArticleController::class, 'create'],
        '~^article/store$~' => [\Controllers\ArticleController::class, 'store'],
        
        '~^comments/delete/(\d+)$~' => [\Controllers\CommentsController::class, 'delete'],
        '~^comments/(\d+)$~' => [Controllers\CommentsController::class, 'view'],
        '~^comments/add/(\d+)$~' => [Controllers\CommentsController::class, 'add'],
        '~^comments/edit/(\d+)$~' => [Controllers\CommentsController::class, 'edit'],
    ];