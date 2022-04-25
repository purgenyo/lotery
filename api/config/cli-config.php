<?php

$container = require_once dirname(__DIR__) . '/config/bootstrap.php';
return \Doctrine\ORM\Tools\Console\ConsoleRunner::createHelperSet(
	$container->get(\Doctrine\ORM\EntityManagerInterface::class)
);