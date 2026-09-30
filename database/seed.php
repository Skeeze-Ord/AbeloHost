<?php

use App\Blog\Services\SeederRunner;

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../app/Blog/Services/SeederRunner.php';

$pdo = createDatabaseConnection();

$seederRunner = new SeederRunner($pdo);

$seederRunner->seed();