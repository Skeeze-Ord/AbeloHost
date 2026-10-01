<?php

use App\Blog\Controllers\CategoryController;
use App\Blog\Controllers\HomeController;
use App\Blog\Controllers\PostController;

return [
    'GET /' => [
        HomeController::class,
        'index',
    ],

    'GET /categories/{id}' => [
        CategoryController::class,
        'show',
    ],

    'GET /posts/{id}' => [
        PostController::class,
        'show',
    ]
];