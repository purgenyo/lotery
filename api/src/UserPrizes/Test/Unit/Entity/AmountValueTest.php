<?php

declare(strict_types=1);

namespace App\UserPrizes\Test\Unit\Entity;

use App\UserPrizes\Entity\AmountValue;
use PHPUnit\Framework\TestCase;
use Webmozart\Assert\InvalidArgumentException;

/**
 * @covers \App\UserPrizes\Entity\AmountValue
 *
 * @internal
 */
final class AmountValueTest extends TestCase
{
    public function testSuccessCreated(): void
    {
        $amountValue = new AmountValue($amount = random_int(0, 4000));
        self::assertEquals($amount, $amountValue->getValue());
    }

    /**
     * @return int[][]
     */
    public function incorrectNumbersProvider(): array
    {
        return [
            [0],
            [-100],
        ];
    }

    /**
     * @dataProvider incorrectNumbersProvider
     */
    public function testThatPassIncorrectValue(int $incorrectNumber): void
    {
        $this->expectException(InvalidArgumentException::class);
        new AmountValue($incorrectNumber);
    }
}
