<?php

use App\Blog\Controllers\CategoryController;
use App\Blog\Controllers\HomeController;

return [
    'GET /' => [
        HomeController::class,
        'index',
    ],

    'GET /categories/{id}' => [
        CategoryController::class,
        'show',
    ],
];