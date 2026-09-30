<?php

function createDatabaseConnection(): PDO
{
    $env = [];

    foreach (file(__DIR__ . '/../.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
        [$key, $value] = explode('=', $line, 2);

        $env[$key] = $value;
    }

    $dsn = sprintf(
        'mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4',
        $env['DB_HOST'],
        $env['DB_PORT'],
        $env['DB_DATABASE']
    );

    return new PDO($dsn, $env['DB_USERNAME'], $env['DB_PASSWORD'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);
}