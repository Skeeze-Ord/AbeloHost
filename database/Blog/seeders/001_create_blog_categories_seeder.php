<?php namespace Database\Blog\Seeders;

use PDO;

class CreateBlogCategoriesSeeder
{
    public function run(PDO $pdo): void
    {
        $categories = [
            [
                'name' => 'PHP',
                'description' => 'Статьи о PHP',
            ],
            [
                'name' => 'Docker',
                'description' => 'Статьи о Docker',
            ],
            [
                'name' => 'MySQL',
                'description' => 'Статьи о MySQL',
            ],
        ];

        $statement = $pdo->prepare("
            INSERT INTO `blog_categories` (`name`, `description`)
            VALUES (:name, :description)
        ");

        foreach ($categories as $category) {
            $statement->bindValue(':name', $category['name']);
            $statement->bindValue(':description', $category['description']);
            $statement->execute();
        }
    }
}