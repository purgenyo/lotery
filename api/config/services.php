<?php

use App\PrizeApi\Contract\PhysicalPrize as PhysicalPrizeInterface;
use App\PrizeApi\PhysicalPrize\PhysicalStaticDataPrize;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return function(ContainerConfigurator $configurator) {
	$services = $configurator->services()
		->defaults()
		->autowire()
		->autoconfigure();

	$services->set(PhysicalPrizeInterface::class, PhysicalStaticDataPrize::class)
		->arg('$constPrizeList', [
			'2eae4be7-890c-4524-984e-df66783dc356',
			'e77ac7f0-907c-4351-8907-21786baf2574',
			'6747fd2a-1f86-4c3f-802b-d9a7b2413110',
		]);
};