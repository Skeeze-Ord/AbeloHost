<?php namespace Database\Blog\Migrations;

use PDO;

class CreateBlogCategoriesTable
{
    public function up(PDO $pdo): void
    {
        $pdo->query("
            CREATE TABLE IF NOT EXISTS `blog_categories` (
                `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
                `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
                
                `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                `name` VARCHAR(255) NOT NULL,
                `description` TEXT NOT NULL
            )
        ");
    }

    public function down(PDO $pdo): void
    {
        $pdo->query("DROP TABLE IF EXISTS `blog_categories`");
    }
}