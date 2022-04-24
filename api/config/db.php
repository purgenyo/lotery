<?php

use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;

$paths = [
	__DIR__ . '/../src/UserPrizes/Entity'
];

$isDevMode = false;

$dbParams = require_once __DIR__ . '/migrations-db.php';

$config = ORMSetup::createAnnotationMetadataConfiguration($paths, $isDevMode);
$em = EntityManager::create($dbParams, $config);


$dbalTypeList = [
	\App\UserPrizes\Entity\DoctrineType\ManagerIdType::NAME => \App\UserPrizes\Entity\DoctrineType\ManagerIdType::class,
	\App\UserPrizes\Entity\DoctrineType\UserIdType::NAME => \App\UserPrizes\Entity\DoctrineType\UserIdType::class,
];

function importTypes(array $classTypes, \Doctrine\ORM\EntityManagerInterface $em): void {
	/**
	 * @var string $className
	 * @var class-string<Type> $class
	 */
	foreach ($classTypes as $className => $class) {
		Type::addType($className, $class);
		$em->getConnection()->getDatabasePlatform()->registerDoctrineTypeMapping($className, $className);
	}
}

importTypes($dbalTypeList, $em);
return $em;