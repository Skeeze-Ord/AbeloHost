<?php namespace App\Blog\Controllers;

use App\Blog\Repositories\CategoryRepository;
use App\Blog\Repositories\PostRepository;
use Smarty\Exception;
use Smarty\Smarty;

class HomeController
{
    public function __construct(
        private Smarty             $smarty,
        private CategoryRepository $categoryRepository,
        private PostRepository     $postRepository,
    )
    {
    }

    /**
     * @throws Exception
     */
    public function index(): void
    {
        $categories = $this->categoryRepository->getWithPosts();

        $result = [];

        foreach ($categories as $category) {
            $result[] = [
                'category' => $category,
                'posts' => $this->postRepository->getLatestByCategory($category->id),
            ];
        }

        $this->smarty->assign('result', $result);
        $this->smarty->display('blog/home.tpl');
    }
}