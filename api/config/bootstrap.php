<?php

declare(strict_types=1);

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Dumper\PhpDumper;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
use Doctrine\DBAL\Types\Type;
require_once dirname(__DIR__) . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$file = '/app/var/cache/container.php';
if (file_exists($file)) {
	require_once $file;
	/** @psalm-suppress UndefinedClass|MixedAssignment */
	$containerBuilder = new ProjectServiceContainer();
} else {
	$containerBuilder = new ContainerBuilder();
	$loader = new PhpFileLoader($containerBuilder, new FileLocator(__DIR__));
	$loader->load(__DIR__ . '/services.php');
	$containerBuilder->compile();
	$dumper = new PhpDumper($containerBuilder);
	/** @psalm-suppress MixedArgumentTypeCoercion */
	file_put_contents($file, $dumper->dump());
}

$dbalTypeList = [
	\App\UserPrizes\Entity\DoctrineType\ManagerIdType::NAME => \App\UserPrizes\Entity\DoctrineType\ManagerIdType::class,
	\App\UserPrizes\Entity\DoctrineType\UserIdType::NAME => \App\UserPrizes\Entity\DoctrineType\UserIdType::class,
	\App\UserPrizes\Entity\DoctrineType\AmountType::NAME => \App\UserPrizes\Entity\DoctrineType\AmountType::class,
	\App\UserPrizes\Entity\DoctrineType\MoneyPrizeIdType::NAME => \App\UserPrizes\Entity\DoctrineType\MoneyPrizeIdType::class,
	\App\UserPrizes\Entity\DoctrineType\DeliveryStatusEnumType::NAME => \App\UserPrizes\Entity\DoctrineType\DeliveryStatusEnumType::class,
	\App\UserPrizes\Entity\DoctrineType\LoyaltyPointPrizeIdentityType::NAME => \App\UserPrizes\Entity\DoctrineType\LoyaltyPointPrizeIdentityType::class,
];

function importTypes(array $classTypes, EntityManagerInterface $em): void {
	/**
	 * @var string $className
	 * @var class-string<Type> $class
	 */
	foreach ($classTypes as $className => $class) {
		Type::addType($className, $class);
		$em->getConnection()->getDatabasePlatform()->registerDoctrineTypeMapping($className, $className);
	}
}

/**
 * @var EntityManagerInterface $em
 * @var ContainerBuilder $containerBuilder
 */
$em = $containerBuilder->get(EntityManagerInterface::class);
importTypes(
	$dbalTypeList, $em,
);

return $containerBuilder;