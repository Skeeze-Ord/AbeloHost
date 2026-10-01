<?php namespace App\Blog\Services;

use App\Blog\Controllers\CategoryController;
use App\Blog\Controllers\HomeController;
use App\Blog\Controllers\PostController;
use App\Blog\Repositories\CategoryRepository;
use App\Blog\Repositories\PostRepository;
use Smarty\Smarty;

readonly class ControllerFactory
{
    public function __construct(
        private Smarty $smarty,
        private CategoryRepository $categoryRepository,
        private PostRepository $postRepository,
    )
    {
    }

    public function create(string $controllerClass): object
    {
        return match ($controllerClass) {
            HomeController::class => new HomeController(
                $this->smarty,
                $this->categoryRepository,
                $this->postRepository,
            ),

            CategoryController::class => new CategoryController(
                $this->smarty,
                $this->categoryRepository,
                $this->postRepository,
            ),

            PostController::class => new PostController(
                $this->smarty,
                $this->postRepository,
            ),

            default => throw new \RuntimeException(
                "Unknown controller: {$controllerClass}"
            ),
        };
    }
}