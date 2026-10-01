<?php namespace App\Blog\Controllers;

use App\Blog\Repositories\PostRepository;
use RuntimeException;
use Smarty\Smarty;

readonly class PostController
{
    public function __construct(
        private Smarty $smarty,
        private PostRepository $postRepository
    )
    {
    }

    public function show(int $postId): void
    {
        $post = $this->postRepository->findById($postId);

        if (!$post) {
            throw new RuntimeException('Post not found');
        }

        $this->postRepository->incrementViews($postId);

        $similarPosts = $this->postRepository->getSimilar($postId);

        $this->smarty->assign('metaTitle', $post->title);
        $this->smarty->assign('metaDescription', $post->description);
        $this->smarty->assign('pageTitle', $post->title);
        $this->smarty->assign('pageDescription', $post->description);

        $this->smarty->assign('post', $post);
        $this->smarty->assign('similarPosts', $similarPosts);

        $this->smarty->display('blog/post.tpl');
    }
}