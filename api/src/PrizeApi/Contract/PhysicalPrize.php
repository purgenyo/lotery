<?php

declare(strict_types=1);

namespace App\PrizeApi\Contract;

interface PhysicalPrize
{
    public function getPrizeIdentity(): string;
}
