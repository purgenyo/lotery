<?php

declare(strict_types=1);

namespace App\Gateway;

use App\Gateway\Contract\HandleRequestInterface;
use App\UserPrizes\Service\RandomPrize\RandomPrize;

final class GeneratePrizeGateway implements HandleRequestInterface
{
    public function __construct(
        private RandomPrize $randomPrize,
    ) {
    }

    public function handleRequest(): array
    {
        return $this->randomPrize->createAndGetRandomPrize();
    }
}
