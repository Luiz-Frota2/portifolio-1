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
// If the script is in /erp/public/index.php, dirname is /erp/public
// We want the base url to be /erp/ (what the user sees) not /erp/public/
// If accessing via http://localhost/erp/, the SCRIPT_NAME is /erp/index.php (via Rewrite) or /erp/public/index.php?
// Let's rely on a simpler approach: relative to the installation.

// Hardcoded for reliability in this specific environment, consistent with user context
// Assuming the app is accessed via /erp/
define('BASE_URL', '/erp');

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
