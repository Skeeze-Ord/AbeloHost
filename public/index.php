<?php

use App\Blog\Controllers\HomeController;
use App\Blog\Repositories\CategoryRepository;
use App\Blog\Repositories\PostRepository;

require __DIR__ . '/../vendor/autoload.php';

require __DIR__ . '/../app/Blog/Models/Category.php';
require __DIR__ . '/../app/Blog/Models/Post.php';

require __DIR__ . '/../app/Blog/Repositories/CategoryRepository.php';
require __DIR__ . '/../app/Blog/Repositories/PostRepository.php';

require __DIR__ . '/../app/Blog/Controllers/HomeController.php';

require __DIR__ . '/../config/database.php';

$smarty = require __DIR__ . '/../config/smarty.php';

$pdo = createDatabaseConnection();

$categoryRepository = new CategoryRepository($pdo);
$postRepository = new PostRepository($pdo);

$controller = new HomeController(
    $smarty,
    $categoryRepository,
    $postRepository,
);

$controller->index();