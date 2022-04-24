<?php

declare(strict_types=1);

namespace App\PrizeApi\AmountPrize;

use App\PrizeApi\Contract\AmountPrize as AmountPrizeInterface;
use App\PrizeApi\Exception\AmountPrizeException;

final class AmountPrize implements AmountPrizeInterface
{
    public function __construct(private int $minInterval, private int $maxInterval)
    {
        if ($minInterval >= $maxInterval) {
            throw AmountPrizeException::maxIntervalMustBeGreaterThanMinInterval($minInterval, $maxInterval);
        }
        if (min([$minInterval, $maxInterval]) < 0) {
            throw AmountPrizeException::minOrMaxIntervalMustBeNotLessThanZero($minInterval, $maxInterval);
        }
    }

    public function getAmount(): int
    {
        return random_int($this->minInterval, $this->maxInterval);
    }
}
