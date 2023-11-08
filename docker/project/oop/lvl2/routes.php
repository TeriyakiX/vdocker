<?php
return [
    '~^hello/(.*)$~' => [\Controllers\MainController::class, 'sayHello'],
    '~^bye/(.*)$~' => [\Controllers\MainController::class, 'sayBye'],
    '~^$~' => [\Controllers\MainController::class, 'main'],
    '~^articles/(\d+)$~' => [\Controllers\ArticlesController::class, 'view'],
    '~^articles/(\d+)/edit$~' => [\Controllers\ArticlesController::class, 'edit'],
    '~^articles/(\d+)/delete$~' => [\Controllers\ArticlesController::class, 'delete'],
    '~^articles/(\d+)/comments/add~' => [\Controllers\CommentsController::class, 'add'],
    '~^articles/add$~' => [\Controllers\ArticlesController::class, 'add'],
    '~^users/register~' => [\Controllers\UsersController::class, 'signUp'],
    '~^users/login$~' => [\Controllers\UsersController::class, 'login'],
    '~^users/logout$~' => [\Controllers\UsersController::class, 'logout'],
];