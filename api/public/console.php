<?php

declare(strict_types=1);

$container = require_once __DIR__ . '/../config/bootstrap.php';

$className = (string)($_SERVER['argv'][1] ?? '');

/** @var \App\UserPrizes\Console\RunConsoleCommand $consoleCommand */
$consoleCommand = $container->get($className);
$consoleCommand->runCommand();
