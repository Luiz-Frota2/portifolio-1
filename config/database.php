<?php

class Database {
    private static $host = 'localhost'; // Hostinger usually uses localhost, change if needed
    private static $db_name = 'u784961086_pdv';
    private static $username = 'u784961086_pdv';
    private static $password = 'h?o3JYzu1E';
    private static $conn = null;

    public static function connect() {
        if (self::$conn !== null) {
            return self::$conn;
        }

        try {
            $dsn = "mysql:host=" . self::$host . ";dbname=" . self::$db_name . ";charset=utf8mb4";
            self::$conn = new PDO($dsn, self::$username, self::$password);
            
            // Secure attributes
            self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            self::$conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            
            return self::$conn;
        } catch(PDOException $e) {
            // In production, log this instead of showing
            die("Connection Error: " . $e->getMessage()); 
        }
    }
}
