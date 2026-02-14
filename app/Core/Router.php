<?php

namespace App\Core;

class Router {
    private $routes = [];

    public function get($path, $callback) {
        $this->routes['GET'][$path] = $callback;
    }

    public function post($path, $callback) {
        $this->routes['POST'][$path] = $callback;
    }

    public function dispatch() {
        $method = $_SERVER['REQUEST_METHOD'];
        
        // Basic path parsing
        $path = $_SERVER['REQUEST_URI'];
        
        // Remove query string
        if (($pos = strpos($path, '?')) !== false) {
            $path = substr($path, 0, $pos);
        }

        // Handle subdirectories if configured (Hostinger might need this)
        // Assuming /public/index.php is the entry, but if in root...
        // Let's trim script_name dir from uri
        $scriptDir = dirname($_SERVER['SCRIPT_NAME']);
        if ($scriptDir !== '/' && strpos($path, $scriptDir) === 0) {
            $path = substr($path, strlen($scriptDir));
        }
        
        $path = $path === '' ? '/' : $path;

        if (isset($this->routes[$method][$path])) {
            $callback = $this->routes[$method][$path];

            if (is_array($callback)) {
                $controllerName = $callback[0];
                $action = $callback[1];
                
                $controller = new $controllerName();
                $controller->$action();
            } else {
                call_user_func($callback);
            }
        } else {
            http_response_code(404);
            echo "404 Not Found";
        }
    }
}
