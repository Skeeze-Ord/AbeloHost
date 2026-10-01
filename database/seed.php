<?php

use App\Blog\Services\SeederRunner;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/database.php';

$pdo = createDatabaseConnection();

$seederRunner = new SeederRunner($pdo);

$seederRunner->seed();