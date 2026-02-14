<?php
// config/database.php

define('DB_HOST', 'localhost');
define('DB_NAME', 'u784961086_pdv');
define('DB_USER', 'u784961086_pdv');
define('DB_PASS', 'h?o3JYzu1E');
define('DB_CHARSET', 'utf8mb4');

try {
    $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
} catch (\PDOException $e) {
    // In production, log the error and show a user-friendly message
    // For now, we show the error to help debugging if connection fails
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
