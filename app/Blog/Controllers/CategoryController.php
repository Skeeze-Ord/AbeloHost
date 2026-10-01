<?php namespace App\Blog\Controllers;

use App\Blog\Repositories\CategoryRepository;
use App\Blog\Repositories\PostRepository;
use RuntimeException;
use Smarty\Smarty;

readonly class CategoryController
{
    public function __construct(
        private Smarty             $smarty,
        private CategoryRepository $categoryRepository,
        private PostRepository     $postRepository
    )
    {
    }

    public function show(int $categoryId): void
    {
        $sortMethod = $_GET['sort'] ?? '';
        $currentPage = max(1, (int)($_GET['page'] ?? 1));
        $perPage = 6;

        $category = $this->categoryRepository->findById($categoryId);

        // Пока без 404
        if (!$category) {
            throw new RuntimeException('Category not found');
        }

        $posts = $this->postRepository->getByCategory($categoryId, $sortMethod, $currentPage, $perPage);
        $postsCount = $this->postRepository->countByCategory($categoryId);

        $totalPages = (int) ceil($postsCount / $perPage);

        $this->smarty->assign('metaTitle', $category->name);
        $this->smarty->assign('metaDescription', $category->description);
        $this->smarty->assign('pageTitle', $category->name);
        $this->smarty->assign('pageDescription', $category->description);

        $this->smarty->assign('category', $category);
        $this->smarty->assign('posts', $posts);
        $this->smarty->assign('postsCount', $postsCount);
        $this->smarty->assign('sortMethod', $sortMethod);
        $this->smarty->assign('currentPage', $currentPage);
        $this->smarty->assign('totalPages', $totalPages);

        $this->smarty->display('blog/category.tpl');
    }
}