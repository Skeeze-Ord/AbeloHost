<?php namespace App\Blog\Services;

use PDO;
use RuntimeException;

class MigrationRunner
{
    public function __construct(
        private PDO $pdo
    )
    {
    }

    public function migrate(): void
    {
        $this->pdo->query("
            CREATE TABLE IF NOT EXISTS `blog_migrations` (
                `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
                `migration` VARCHAR(255) NOT NULL,
                `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
            )
        ");

        $executedMigrations = $this->getExecutedMigrations();

        $migrationsPath = dirname(__DIR__, 3) . '/database/Blog/migrations';

        $files = glob($migrationsPath . '/*.php');

        sort($files);

        foreach ($files as $file) {
            $filename = basename($file, '.php');

            if (in_array($filename, $executedMigrations, true)) {
                continue;
            }

            $classesBefore = get_declared_classes();

            require_once $file;

            $classesAfter = get_declared_classes();

            $newClasses = array_diff($classesAfter, $classesBefore);
            if (empty($newClasses)) {
                throw new RuntimeException("Не удалось найти класс миграции: {$filename}");
            }

            $migrationClass = reset($newClasses);

            $migration = new $migrationClass();

            $migration->up($this->pdo);

            $this->pdo->prepare("
                INSERT INTO `blog_migrations` (`migration`)
                VALUES (:migration)
            ")->execute([
                'migration' => $filename,
            ]);
        }
    }

    private function getExecutedMigrations(): array
    {
        $stmt = $this->pdo->query("
            SELECT `migration` FROM `blog_migrations`
        ");

        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
}