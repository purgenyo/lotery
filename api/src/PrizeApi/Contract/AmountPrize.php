<?php

declare(strict_types=1);

namespace App\PrizeApi\Contract;

interface AmountPrize
{
    public function getAmount(): int;
}
