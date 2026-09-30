<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/database.php';

use App\Blog\Services\MigrationRunner;

$pdo = createDatabaseConnection();

$migrationRunner = new MigrationRunner($pdo);

$migrationRunner->migrate();