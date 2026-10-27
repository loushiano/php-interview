<?php

/*
 * Front controller for the PHP built-in server.
 * Apache uses .htaccess instead and never hits this file.
 *
 *   php -S localhost:8080 router.php
 */
$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
$file = __DIR__ . $uri;

if ($uri !== '/' && is_file($file)) {
    return false;
}

$_GET['url'] = trim($uri, '/');
require __DIR__ . '/index.php';
