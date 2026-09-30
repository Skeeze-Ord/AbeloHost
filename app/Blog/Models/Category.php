<?php namespace App\Blog\Models;

class Category
{
    public function __construct(
        public int    $id,
        public string $name,
        public string $description,
        public string $createdAt,
        public string $updatedAt,
    )
    {
    }
}