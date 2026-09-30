<?php namespace Database\Blog\Seeders;

use PDO;

class CreateBlogPostsSeeder
{
    public function run(PDO $pdo): void
    {
        $posts = [
            [
                'image' => 'php-8-3.jpg',
                'title' => 'Что нового в PHP 8.3',
                'description' => 'Краткий обзор основных изменений и возможностей PHP 8.3.',
                'content' => 'PHP 8.3 добавляет несколько новых возможностей языка и улучшений производительности. В этой статье рассмотрим наиболее заметные изменения.',
                'published_at' => '2026-09-25 10:00:00',
                'views_count' => 125,
                'categories' => [1],
            ],
            [
                'image' => 'docker-php.jpg',
                'title' => 'Запуск PHP-проекта в Docker',
                'description' => 'Разбираем базовую структуру Docker-окружения для PHP-проекта.',
                'content' => 'Docker позволяет изолировать PHP, веб-сервер и базу данных в отдельных контейнерах. Рассмотрим базовую структуру такого окружения.',
                'published_at' => '2026-09-26 12:30:00',
                'views_count' => 340,
                'categories' => [1, 2],
            ],
            [
                'image' => 'mysql-indexes.jpg',
                'title' => 'Индексы в MySQL',
                'description' => 'Для чего нужны индексы и как они влияют на выполнение запросов.',
                'content' => 'Индексы позволяют MySQL быстрее находить необходимые строки. При этом неправильное использование индексов может увеличить стоимость операций записи.',
                'published_at' => '2026-09-20 09:15:00',
                'views_count' => 580,
                'categories' => [3],
            ],
            [
                'image' => 'pdo.jpg',
                'title' => 'Работа с MySQL через PDO',
                'description' => 'Основы подключения PHP-приложения к MySQL с использованием PDO.',
                'content' => 'PDO предоставляет единый интерфейс для работы с различными базами данных. В статье рассмотрим подключение и подготовленные запросы.',
                'published_at' => '2026-09-23 15:00:00',
                'views_count' => 215,
                'categories' => [1, 3],
            ],
            [
                'image' => 'docker-compose.jpg',
                'title' => 'Docker Compose для PHP и MySQL',
                'description' => 'Как связать PHP-приложение и MySQL с помощью Docker Compose.',
                'content' => 'Docker Compose позволяет описать несколько связанных контейнеров в одном YAML-файле. Разберём взаимодействие PHP-приложения и MySQL.',
                'published_at' => '2026-09-28 11:45:00',
                'views_count' => 95,
                'categories' => [2, 3],
            ],
            [
                'image' => 'php-docker.jpg',
                'title' => 'PHP-приложение в контейнере',
                'description' => 'Практический пример запуска PHP-приложения внутри Docker-контейнера.',
                'content' => 'Контейнеризация позволяет зафиксировать окружение приложения и упростить его запуск на разных машинах.',
                'published_at' => '2026-09-29 08:00:00',
                'views_count' => 760,
                'categories' => [1, 2],
            ],
        ];

        $statement = $pdo->prepare("
            INSERT INTO `blog_posts` (`image`, `title`, `description`, `content`, `published_at`, `views_count`)
            VALUES (:image, :title, :description, :content, :published_at, :views_count);
        ");

        $categoryStatement = $pdo->prepare("
            INSERT INTO `blog_posts_categories` (`post_id`, `category_id`)
            VALUES (:post_id, :category_id)
        ");

        foreach ($posts as $post) {
            $statement->bindValue(':image', $post['image']);
            $statement->bindValue(':title', $post['title']);
            $statement->bindValue(':description', $post['description']);
            $statement->bindValue(':content', $post['content']);
            $statement->bindValue(':published_at', $post['published_at']);
            $statement->bindValue(':views_count', $post['views_count']);
            $statement->execute();

            $postId = (int) $pdo->lastInsertId();

            foreach ($post['categories'] as $categoryId) {
                $categoryStatement->execute([
                    'post_id' => $postId,
                    'category_id' => $categoryId,
                ]);
            }
        }
    }
}