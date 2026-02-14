<?php
session_start();

// Validating for PHP Built-in Server
if (php_sapi_name() === 'cli-server') {
    $path = __DIR__ . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    if (is_file($path)) {
        return false;
    }
}

// Load basics
require_once __DIR__ . '/../autoload.php';

use App\Core\Router;
use App\Controllers\AuthController;
use App\Controllers\DashboardController;

$router = new Router();

// Define Routes

// Auth
$router->get('/login', [AuthController::class, 'loginForm']);
$router->post('/login', [AuthController::class, 'login']);
$router->get('/logout', [AuthController::class, 'logout']);

// Dashboard
$router->get('/', [DashboardController::class, 'index']); // Alias
$router->get('/dashboard', [DashboardController::class, 'index']);

// Dispatch
$router->dispatch();
