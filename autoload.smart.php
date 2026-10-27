<?php

session_start();

define('ds', DIRECTORY_SEPARATOR);
define('ws', '/');
define('dirBase', __DIR__ . ds);
define('dirIncludes', dirBase . 'Includes' . ds);

function app_is_ssl() {
    if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') {
        return true;
    }
    if (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
        return true;
    }
    return false;
}

function h($value) {
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

include_once dirIncludes . 'secrets.php';
include_once dirIncludes . 'constants.php';

$documentRoot = rtrim((string) ($_SERVER['DOCUMENT_ROOT'] ?? ''), ds);
$relative = trim(str_replace($documentRoot, '', dirBase), ds);
$prefix = str_replace(ds, ws, $relative);
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';
define(
    'SITE_LINK',
    (app_is_ssl() ? 'https://' : 'http://') . $host . ws . ($prefix !== '' ? $prefix . ws : '')
);

spl_autoload_register(function ($class) {
    $directories = array(
        'System/Core/',
        'System/Database/',
        'System/Database/Adapters/',
        'System/Database/Drivers/',
        'Controllers/',
        'Models/',
        'libs/Common/',
    );
    foreach ($directories as $directory) {
        $file = dirBase . $directory . $class . '.php';
        if (is_readable($file)) {
            include $file;
            return;
        }
    }
});
