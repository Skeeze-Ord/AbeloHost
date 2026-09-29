<?php namespace Database\Blog\Migrations;

use PDO;

class CreateBlogPostsTable
{
    public function up(PDO $pdo): void
    {
        $pdo->query("
            CREATE TABLE IF NOT EXISTS `blog_posts` (
                `created_at` DATETIME NOT NULL,
                `updated_at` DATETIME NOT NULL,
                
                `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                `image` VARCHAR(255) NOT NULL,
                `title` VARCHAR(255) NOT NULL,
                `description` TEXT NOT NULL,
                `content` TEXT NOT NULL,
                `published_at` DATETIME NOT NULL,
                `views_count` INT UNSIGNED NOT NULL DEFAULT 0,
                
                INDEX (`published_at`),
                INDEX (`views_count`)
            )
        ");
    }

    public function down(PDO $pdo): void
    {
        $pdo->query("DROP TABLE IF EXISTS `blog_posts`");
    }
}