<?php

declare(strict_types=1);

require_once dirname(__DIR__) . '/vendor/autoload.php';

/** @var \Doctrine\ORM\EntityManagerInterface $entityManager */
$entityManager = require_once '../config/db.php';
$containerBuilder = require_once '../config/container-config.php';
$containerBuilder->set(\Doctrine\ORM\EntityManagerInterface::class, $entityManager);
