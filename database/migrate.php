<?php

use App\Blog\Services\MigrationRunner;

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../app/Blog/Services/MigrationRunner.php';

$pdo = createDatabaseConnection();

$migrationRunner = new MigrationRunner($pdo);

$migrationRunner->migrate();