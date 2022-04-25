<?php

declare(strict_types=1);

namespace App\UserPrizes\Service\RandomPrize;

interface PrizeContent
{
    public function getContent(): array;
}
