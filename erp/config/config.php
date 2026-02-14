<?php
// erp/config/config.php

// Define the Base URL of the application
// This constant generates the absolute URL to your project root.
// Adjust the detecting logic if necessary, or hardcode it if hosting in a subfolder is tricky.

// Detect protocol
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";

// Detect host
$host = $_SERVER['HTTP_HOST'];

// Detect path relative to web root
// If the script is in /erp/public/index.php, we want /erp
$script_name = $_SERVER['SCRIPT_NAME']; // /erp/public/index.php
$script_dir = dirname($script_name);    // /erp/public

// Remove /public if it exists in the path (to allow access from root /erp)
$base_path = str_replace('/public', '', $script_dir);

// Ensure no trailing slash unless it's just /
$base_path = rtrim($base_path, '/');

define('BASE_URL', $protocol . $host . $base_path);

// Directory Separator
define('DS', DIRECTORY_SEPARATOR);

// Application Root Path
define('ROOT_PATH', dirname(__DIR__) . DS);
define('APP_PATH', ROOT_PATH . 'app' . DS);

// Error Repoorting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Timezone
date_default_timezone_set('America/Sao_Paulo');
