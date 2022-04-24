<?php

declare(strict_types=1);

namespace App\PrizeApi\Test\Unit;

use App\PrizeApi\AmountPrize\AmountPrize;
use App\PrizeApi\Exception\AmountPrizeException;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\PrizeApi\AmountPrize\AmountPrize
 *
 * @internal
 */
final class AmountPrizeTest extends TestCase
{
    public function testSuccessGetAmount(): void
    {
        /** @var \App\PrizeApi\Contract\AmountPrize $amountPrize */
        $amountPrize = new AmountPrize(random_int(0, 100), random_int(200, 400));
        self::assertIsInt($amountPrize->getAmount());
    }

    /**
     * @return int[][]
     */
    public function underZeroNumbersProvider(): array
    {
        return [
            [-1, 10],
            [-10, -5],
        ];
    }

    /**
     * @return int[][]
     */
    public function greaterNumbersProvider(): array
    {
        return [
            [10, 5],
            [10, 10],
        ];
    }

    /**
     * @dataProvider greaterNumbersProvider
     */
    public function testThatMinIntervalGreaterThenMaxInterval(int $minInterval, int $maxInterval): void
    {
        $this->expectException(AmountPrizeException::class);
        $this->expectExceptionMessage(AmountPrizeException::maxIntervalMustBeGreaterThanMinInterval(
            $minInterval,
            $maxInterval
        )->getMessage());
        new AmountPrize($minInterval, $maxInterval);
    }

    /**
     * @dataProvider underZeroNumbersProvider
     */
    public function testThatMinOrMaxIntervalLessThanZero(int $minInterval, int $maxInterval): void
    {
        $this->expectException(AmountPrizeException::class);
        $this->expectExceptionMessage(AmountPrizeException::minOrMaxIntervalMustBeNotLessThanZero(
            $minInterval,
            $maxInterval
        )->getMessage());
        new AmountPrize($minInterval, $maxInterval);
    }
}
