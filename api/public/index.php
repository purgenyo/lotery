<?php

declare(strict_types=1);

use App\Gateway\CheckUserIdentityDecorator;

$container = require_once __DIR__ . '/../config/bootstrap.php';

$routes = [
    'api/v1/generate/prize' => CheckUserIdentityDecorator::class,
];

foreach ($routes as $route => $gateway) {
    header('Content-Type: application/json; charset=utf-8');
    /** @psalm-suppress MixedArgument */
    if (str_contains($_SERVER['REQUEST_URI'] ?? '-1', $route)) {
        /** @var \App\Gateway\Contract\HandleRequestInterface $handler */
        $handler = $container->get($gateway);
        echo $handler->handleRequest();
    }
}
