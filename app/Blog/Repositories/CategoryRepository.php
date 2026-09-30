<?php namespace App\Blog\Repositories;

use App\Blog\Models\Category;
use PDO;

readonly class CategoryRepository
{
    public function __construct(private PDO $pdo)
    {
    }

    public function getWithPosts(): array
    {
        $rows = $this->pdo
            ->query("
                SELECT DISTINCT `c`.*
                FROM `blog_categories` `c`
                INNER JOIN `blog_posts_categories` `pc` ON `pc`.`category_id` = `c`.`id`
                INNER JOIN `blog_posts` `p` ON `p`.`id` = `pc`.`post_id`
                ORDER BY `c`.`name`
            ")
            ->fetchAll(PDO::FETCH_ASSOC);

        $categories = [];

        foreach ($rows as $row) {
            $categories[] = $this->createCategory($row);
        }

        return $categories;
    }

    public function findById(int $categoryId): ?Category
    {
        $stmt = $this->pdo
            ->prepare("
                SELECT *
                FROM `blog_categories`
                WHERE `id` = :categoryId
            ");

        $stmt->execute(['categoryId' => $categoryId]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row === false) {
            return null;
        }

        return $this->createCategory($row);
    }

    private function createCategory(array $row): Category
    {
        return new Category(
            id: (int)$row['id'],
            name: $row['name'],
            description: $row['description'],
            createdAt: $row['created_at'],
            updatedAt: $row['updated_at'],
        );
    }
}