<?php

use App\Blog\Repositories\CategoryRepository;
use App\Blog\Repositories\PostRepository;
use App\Blog\Services\ControllerFactory;
use App\Blog\Exceptions\NotFoundException;
use Smarty\Smarty;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../config/database.php';

$smarty = require __DIR__ . '/../config/smarty.php';

$pdo = createDatabaseConnection();

$categoryRepository = new CategoryRepository($pdo);
$postRepository = new PostRepository($pdo);

$controllerFactory = new ControllerFactory(
    $smarty,
    $categoryRepository,
    $postRepository
);

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

        $controller = $controllerFactory->create($controllerClass);

        try {
            $controller->$action();
        } catch (NotFoundException $exception) {
            renderNotFound($smarty);
        }

        exit;
    }

    if (str_contains($routePath, '{id}')) {
        $pattern = '#^' . str_replace(
                '{id}',
                '(\d+)',
                $routePath
            ) . '$#';

        if (preg_match($pattern, $path, $matches)) {
            [$controllerClass, $action] = $handler;

            $controller = $controllerFactory->create($controllerClass);

            try {
                $controller->$action((int)$matches[1]);
            } catch (NotFoundException $exception) {
                renderNotFound($smarty);
            }

            exit;
        }
    }
}

renderNotFound($smarty);

function renderNotFound(Smarty $smarty): never
{
    http_response_code(404);

    $smarty->assign('metaTitle', '404');
    $smarty->assign('metaDescription', '404 - Страница не найдена');

    $smarty->display('site/404.tpl');

    exit;
}