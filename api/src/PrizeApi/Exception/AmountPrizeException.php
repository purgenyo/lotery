<?php

declare(strict_types=1);

namespace App\PrizeApi\Exception;

use Exception;

/**
 * @codeCoverageIgnore
 */
final class AmountPrizeException extends Exception
{
    public static function maxIntervalMustBeGreaterThanMinInterval(int $minInterval, int $maxInterval): self
    {
        return new self(
            "Tried set intervals but max interval={$maxInterval}"
        . " must be greater than min interval {$minInterval}"
        );
    }

    public static function minOrMaxIntervalMustBeNotLessThanZero(int $maxInterval, int $minInterval): self
    {
        return new self(
            "Min ({$minInterval}) or Max ({$maxInterval}) intervals"
            . ' must not be less than zero'
        );
    }
}
