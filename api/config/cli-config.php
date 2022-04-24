<?php

require_once dirname(__DIR__) . '/vendor/autoload.php';

return \Doctrine\ORM\Tools\Console\ConsoleRunner::createHelperSet(
	require_once __DIR__ . '/db.php'
);