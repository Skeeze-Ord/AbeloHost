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
        $limit = (int)$limit;

        $rowsStmt = $this->pdo
            ->prepare("
                SELECT p.*
                FROM `blog_posts` p
                INNER JOIN `blog_posts_categories` pc ON p.id = pc.post_id
                WHERE pc.category_id = :categoryId
                ORDER BY p.published_at DESC
                LIMIT {$limit}
            ");
        $rowsStmt->bindValue(':categoryId', $categoryId, PDO::PARAM_INT);
        $rowsStmt->execute();

        $rows = $rowsStmt->fetchAll(PDO::FETCH_ASSOC);

        $posts = [];
        foreach ($rows as $row) {
            $posts[] = $this->createPost($row);
        }

        return $posts;
    }

    public function findById(int $postId): ?Post
    {
        $stmt = $this->pdo
            ->prepare("
                SELECT *
                FROM `blog_posts`
                WHERE id = :postId
            ");
        $stmt->execute(['postId' => $postId]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row === false) {
            return null;
        }

        return $this->createPost($row);
    }

    public function getSimilar(int $postId, int $limit = 3): array
    {
        $limit = (int)$limit;

        $rowsStmt = $this->pdo
            ->prepare("
                SELECT DISTINCT p.*
                FROM `blog_posts` p
                INNER JOIN `blog_posts_categories` pc ON p.id = pc.post_id
                WHERE pc.category_id IN (
                    SELECT category_id
                    FROM `blog_posts_categories`
                    WHERE post_id = :currentPostId
                )
                AND p.id != :postId
                ORDER BY p.published_at DESC
                LIMIT {$limit}
            ");
        $rowsStmt->bindValue(':postId', $postId, PDO::PARAM_INT);
        $rowsStmt->bindValue(':currentPostId', $postId, PDO::PARAM_INT);
        $rowsStmt->execute();

        $rows = $rowsStmt->fetchAll(PDO::FETCH_ASSOC);

        $posts = [];
        foreach ($rows as $row) {
            $posts[] = $this->createPost($row);
        }

        return $posts;
    }

    public function countByCategory(int $categoryId): int
    {
        $stmt = $this->pdo->prepare("
            SELECT COUNT(DISTINCT p.id) AS total
            FROM `blog_posts` p
            INNER JOIN `blog_posts_categories` pc ON p.id = pc.post_id
            WHERE pc.category_id = :categoryId
        ");
        $stmt->execute(['categoryId' => $categoryId]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return (int)$row['total'];
    }

    public function getByCategory(
        int    $categoryId,
        string $sort,
        int    $page = 1,
        int    $perPage = 6
    ): array
    {
        $page = (int)$page;
        $perPage = (int)$perPage;

        $orderBy = match ($sort) {
            'views' => 'p.views_count DESC',
            default => 'p.published_at DESC',
        };

        $offset = ($page - 1) * $perPage;

        $rowsStmt = $this->pdo
            ->prepare("
                SELECT p.*
                FROM `blog_posts` p
                INNER JOIN `blog_posts_categories` pc ON p.id = pc.post_id
                WHERE pc.category_id = :categoryId
                ORDER BY {$orderBy}
                LIMIT {$perPage}
                OFFSET {$offset}
            ");
        $rowsStmt->bindValue(':categoryId', $categoryId, PDO::PARAM_INT);
        $rowsStmt->execute();

        $rows = $rowsStmt->fetchAll(PDO::FETCH_ASSOC);

        $posts = [];
        foreach ($rows as $row) {
            $posts[] = $this->createPost($row);
        }

        return $posts;
    }

    private function createPost(array $row): Post
    {
        return new Post(
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
}