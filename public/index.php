<?php
session_start();

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
