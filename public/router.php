<?php

declare(strict_types=1);

/**
 * Router para el servidor PHP embebido (`php -S 127.0.0.1:8765 -t public public/router.php`).
 * Sirve assets estáticos existentes y delega el resto al Front Controller `public/index.php`.
 */
$uriPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
$staticFile = __DIR__ . $uriPath;

if ($uriPath !== '/' && is_file($staticFile)) {
    return false;
}

require __DIR__ . '/index.php';
