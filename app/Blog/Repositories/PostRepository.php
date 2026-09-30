<?php namespace App\Blog\Repositories;

use App\Blog\Models\Post;
use PDO;

readonly class PostRepository
{
    public function __construct(private PDO $pdo)
    {
    }

    public function getLatestByCategory(int $categoryId, int $limit = 3): array
    {
        $limit = (int) $limit;

        $rowsStatement = $this->pdo
            ->prepare("
                SELECT p.*
                FROM `blog_posts` p
                INNER JOIN `blog_posts_categories` pc ON p.id = pc.post_id
                WHERE pc.category_id = :categoryId
                ORDER BY p.published_at DESC
                LIMIT  {$limit}
            ");

        $rowsStatement->bindValue(':categoryId', $categoryId, PDO::PARAM_INT);
        $rowsStatement->execute();

        $rows = $rowsStatement->fetchAll(PDO::FETCH_ASSOC);

        $posts = [];
        foreach ($rows as $row) {
            $posts[] = new Post(
                id: (int)$row['id'],
                image: $row['image'],
                title: $row['title'],
                description: $row['description'],
                content: $row['content'],
                publishedAt: $row['published_at'],
                viewsCount: (int)$row['views_count'],
                createdAt: $row['created_at'],
                updatedAt: $row['updated_at'],
            );
        }

        return $posts;
    }
}