<?php

use App\Auth\Contract\UserIdentityInterface;
use App\Auth\UserIdentityExample;
use App\Gateway\CheckUserIdentityDecorator;
use App\Gateway\GeneratePrizeGateway;
use App\Gateway\JsonResponseDecorator;
use App\PrizeApi\AmountPrize\AmountPrize;
use App\PrizeApi\Contract\PhysicalPrize as PhysicalPrizeInterface;
use App\PrizeApi\PhysicalPrize\PhysicalStaticDataPrize;
use App\UserAccountApi\Contract\SendAmount;
use App\UserAccountApi\UserAccountExample;
use App\UserPrizes\Console\SendMoneyPrizesToUsers;
use App\UserPrizes\Service\RandomPrize\LoyaltyPointPrizeService;
use App\UserPrizes\Service\RandomPrize\MoneyPrizeService;
use App\UserPrizes\Service\RandomPrize\RandomPrize;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\ORMSetup;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use function Symfony\Component\DependencyInjection\Loader\Configurator\service;

return function(ContainerConfigurator $configurator) {
	$dbParams = require_once __DIR__ . '/migrations-db.php';

	$services = $configurator->services()
		->defaults()
		->autowire()
		->autoconfigure();

	$services->set(ORMSetup::class, ORMSetup::class)
		->factory([ORMSetup::class, 'createAnnotationMetadataConfiguration'])
		->args([[
			__DIR__ . '/../src/UserPrizes/Entity'
		]]);

	$services->set(\Doctrine\ORM\EntityManagerInterface::class)
		->factory([\Doctrine\ORM\EntityManager::class, 'create'])
		->args([$dbParams, service(ORMSetup::class)])
		->public();

	$services->load('App\\PrizeApi\\', '../src/PrizeApi/*')
		->exclude('../src/PrizeApi/{Test}');

	$services->load('App\\Gateway\\', '../src/Gateway/*')
		->exclude('../src/Gateway/{Test}');

	$services->load('App\\UserPrizes\\', '../src/UserPrizes/*')
		->exclude('../src/UserPrizes/{Entity,Test}');

	$services->set(UserIdentityInterface::class, UserIdentityExample::class);

	$services->set('money_amount_prize', AmountPrize::class)
		->args([
			'$minInterval' => $_ENV['MIN_MONEY_PRIZE_INTERVAL'],
			'$maxInterval' => $_ENV['MAX_MONEY_PRIZE_INTERVAL'],
		]);

	$services->set('money_amount_prize', AmountPrize::class)
		->args([
			'$minInterval' => $_ENV['MIN_MONEY_PRIZE_INTERVAL'],
			'$maxInterval' => $_ENV['MAX_MONEY_PRIZE_INTERVAL'],
		]);

	$services->set('loyalty_amount_prize', AmountPrize::class)
		->args([
			'$minInterval' => $_ENV['MIN_LOYALTY_PRIZE_INTERVAL'],
			'$maxInterval' => $_ENV['MAX_LOYALTY_PRIZE_INTERVAL'],
		]);

	$services->set('generate_prize_gateway', GeneratePrizeGateway::class)->autowire();

	$services->set(JsonResponseDecorator::class, JsonResponseDecorator::class)
		->arg('$handleRequest', service('generate_prize_gateway'));

	$services->set(CheckUserIdentityDecorator::class, CheckUserIdentityDecorator::class)
		->arg('$handleRequest', service(JsonResponseDecorator::class))
		->public();


	$services->set('user_prizes_repository', EntityRepository::class)
		->factory([service(EntityManagerInterface::class), 'getRepository'])
		->args([\App\UserPrizes\Entity\Manager::class])
		->private();

	$services->set(App\UserPrizes\Command\InitManagerCommand\Handler::class)
		->autowire()
		->arg('$repository', service('user_prizes_repository'))
		->public();

	$services->set(SendAmount::class, UserAccountExample::class);

	$services->set(App\UserPrizes\Command\SendMoneyPrizeToUser\Handler::class)
		->arg('$billApi', service(SendAmount::class))
		->arg('$repository', service('user_prizes_repository'))
		->autowire()
	;

	$services->set(App\UserPrizes\Command\CreateMoneyPrize\Handler::class)
		->autowire()
		->arg('$repository', service('user_prizes_repository'))
		->arg('$amountPrize', service('money_amount_prize'))
		->public();

	$services->set(App\UserPrizes\Command\CreateLoyaltyPointPrize\Handler::class)
		->autowire()
		->arg('$repository', service('user_prizes_repository'))
		->arg('$amountPrize', service('loyalty_amount_prize'))
		->public();

	$services->set(RandomPrize::class)
		->arg('$randomList', [
			service(MoneyPrizeService::class),
			service(LoyaltyPointPrizeService::class),
		]);

	$services->set(SendMoneyPrizesToUsers::class)->public();

	$services->set(PhysicalPrizeInterface::class, PhysicalStaticDataPrize::class)
		->arg('$constPrizeList', [
			'2eae4be7-890c-4524-984e-df66783dc356',
			'e77ac7f0-907c-4351-8907-21786baf2574',
			'6747fd2a-1f86-4c3f-802b-d9a7b2413110',
		]);
};