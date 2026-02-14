<?php
// config/database.example.php
// Copie este arquivo para database.php e preencha com suas credenciais

declare(strict_types=1);

function db(): PDO
{
    static $pdo = null;
    if ($pdo instanceof PDO) return $pdo;

    $DB_HOST = 'localhost';
    $DB_NAME = 'nome_do_banco';
    $DB_USER = 'usuario_do_banco';
    $DB_PASS = 'senha_do_banco';
    $DB_PORT = '3306';

    $dsn = "mysql:host={$DB_HOST};port={$DB_PORT};dbname={$DB_NAME};charset=utf8mb4";

    try {
        $pdo = new PDO($dsn, $DB_USER, $DB_PASS, [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ]);

        $pdo->exec("SET time_zone = '-03:00'");
        return $pdo;

    } catch (PDOException $e) {
        die("Erro de conexão com o banco: " . $e->getMessage());
    }
}
