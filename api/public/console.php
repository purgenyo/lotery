<?php

declare(strict_types=1);

/** @var \Symfony\Component\DependencyInjection\ContainerBuilder $container */
$container = require_once __DIR__ . '/../config/bootstrap.php';

$className = $_SERVER['argv'][1];
$container->get($className)->runCommand();
