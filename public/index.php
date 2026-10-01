<?php

use App\Blog\Controllers\HomeController;
use App\Blog\Controllers\CategoryController;
use App\Blog\Repositories\CategoryRepository;
use App\Blog\Repositories\PostRepository;

require __DIR__ . '/../vendor/autoload.php';

require __DIR__ . '/../app/Blog/Models/Category.php';
require __DIR__ . '/../app/Blog/Models/Post.php';

require __DIR__ . '/../app/Blog/Repositories/CategoryRepository.php';
require __DIR__ . '/../app/Blog/Repositories/PostRepository.php';

require __DIR__ . '/../app/Blog/Controllers/HomeController.php';
require __DIR__ . '/../app/Blog/Controllers/CategoryController.php';

require __DIR__ . '/../config/database.php';

$smarty = require __DIR__ . '/../config/smarty.php';

$pdo = createDatabaseConnection();

$categoryRepository = new CategoryRepository($pdo);
$postRepository = new PostRepository($pdo);

$routes = require __DIR__ . '/../routes/web.php';

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

foreach ($routes as $route => $handler) {
    [$routeMethod, $routePath] = explode(' ', $route, 2);

    if ($method !== $routeMethod) {
        continue;
    }

    if ($routePath === $path) {
        [$controllerClass, $action] = $handler;

        $controller = new $controllerClass(
            $smarty,
            $categoryRepository,
            $postRepository,
        );

        $controller->$action();

        exit;
    }

    if ($routePath === '/categories/{id}') {
        $pattern = '#^/categories/(\d+)$#';

        if (preg_match($pattern, $path, $matches)) {
            [$controllerClass, $action] = $handler;

            $controller = new $controllerClass(
                $smarty,
                $categoryRepository,
                $postRepository,
            );

            $controller->$action((int)$matches[1]);

            exit;
        }
    }
}