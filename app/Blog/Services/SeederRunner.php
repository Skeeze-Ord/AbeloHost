<?php namespace App\Blog\Services;

use PDO;
use RuntimeException;

class SeederRunner
{
    public function __construct(
        private PDO $pdo
    )
    {
    }

    public function seed(): void
    {
        $this->pdo->query("
            CREATE TABLE IF NOT EXISTS `blog_seeders` (
                `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
                `seeder` VARCHAR(255) NOT NULL,
                `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
            )
        ");

        $executedSeeders = $this->getExecutedSeeders();
        $seedersPath = dirname(__DIR__, 3) . '/database/Blog/seeders';
        $files = glob($seedersPath . '/*.php');
        sort($files);

        foreach ($files as $file) {
            $filename = basename($file, '.php');

            if (in_array($filename, $executedSeeders, true)) {
                continue;
            }

            $classesBefore = get_declared_classes();
            require_once $file;

            $classesAfter = get_declared_classes();

            $newClasses = array_diff($classesAfter, $classesBefore);
            if (empty($newClasses)) {
                throw new RuntimeException("Не удалось найти класс seeder: {$filename}");
            }

            $seederClass = reset($newClasses);
            $seeder = new $seederClass();
            $seeder->run($this->pdo);

            $this->pdo->prepare("
                INSERT INTO `blog_seeders` (`seeder`)
                VALUES (:seeder)
            ")->execute([
                'seeder' => $filename,
            ]);
        }
    }

    private function getExecutedSeeders(): array
    {
        $stmt = $this->pdo->query("
            SELECT `seeder` FROM `blog_seeders`
        ");

        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
}