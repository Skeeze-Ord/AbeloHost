<?php namespace Database\Blog\Migrations;

use PDO;

class CreateBlogPostsCategoriesTable
{
    public function up(PDO $pdo): void
    {
        $pdo->query("
            CREATE TABLE IF NOT EXISTS `blog_posts_categories` (
                `post_id` INT UNSIGNED NOT NULL,
                `category_id` INT UNSIGNED NOT NULL,
                PRIMARY KEY (`post_id`, `category_id`),
                
                FOREIGN KEY (post_id)
                    REFERENCES blog_posts(id)
                    ON DELETE CASCADE,
                
                FOREIGN KEY (category_id)
                    REFERENCES blog_categories(id)
                    ON DELETE CASCADE
            )
        ");
    }

    public function down(PDO $pdo): void
    {
        $pdo->query("DROP TABLE IF EXISTS `blog_posts_categories`");
    }
}