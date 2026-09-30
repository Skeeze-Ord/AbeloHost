<?php namespace App\Blog\Models;

class Post
{
    public function __construct(
        public int    $id,
        public string $image,
        public string $title,
        public string $description,
        public string $content,
        public string $publishedAt,
        public int    $viewsCount,
        public string $createdAt,
        public string $updatedAt,
    )
    {
    }
}