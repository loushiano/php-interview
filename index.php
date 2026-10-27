<?php

require_once __DIR__ . '/autoload.smart.php';

try {
    Router::route(new Request);
} catch (Exception $error) {
    $controller = new Errors;
    $controller->error($error->getMessage());
}
