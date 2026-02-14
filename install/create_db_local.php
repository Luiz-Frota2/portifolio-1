<?php
try {
    // Connect without DB selected
    $pdo = new PDO("mysql:host=localhost", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $dbname = "u784961086_pdv";
    $dbname = "`".str_replace("`","``",$dbname)."`";
    $pdo->query("CREATE DATABASE IF NOT EXISTS $dbname CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    echo "Database created successfully<br>";
} catch (PDOException $e) {
    echo "Error creating database: " . $e->getMessage();
}
