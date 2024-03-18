<?php

/**
 *  Config File For Handel Route, Database And Request
*/
$scriptName = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
define('HTTP_URL', '/'. substr_replace(trim($_SERVER['REQUEST_URI'], '/'), '', 0, strlen($scriptName)));

// Define Path Application
define('SCRIPT', str_replace('\\', '/', rtrim(__DIR__, '/')) . '/');
define('SYSTEM', SCRIPT . 'System/');
define('CONTROLLERS', SCRIPT . 'App/Controllers/');
define('MODELS', SCRIPT . 'App/Models/');
define('UPLOAD', SCRIPT . 'Upload/');
define("BURL", "http://localhost:8000/");
// Config Database
define('DATABASE', [
    'Port'   => '3306',
    'Host'   => 'localhost',
    'Driver' => 'PDO',
    'Name'   => 'simple-mvc',
    'User'   => 'root',
    'Pass'   => '',
]);



