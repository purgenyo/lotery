<?php

declare(strict_types=1);

use DG\BypassFinals;

require dirname(__DIR__) . '/vendor/autoload.php';
BypassFinals::enable();

echo "\nMemory limit: " . ini_get('memory_limit') . "\n\n";

