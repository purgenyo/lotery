<?php

declare(strict_types=1);

namespace App\PrizeApi\Test\Unit;

use App\PrizeApi\Exception\PhysicalStaticDataPrizeException;
use App\PrizeApi\PhysicalPrize\PhysicalStaticDataPrize;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class PhysicalPrizeTest extends TestCase
{
    public function testSuccess(): void
    {
        $prize = new PhysicalStaticDataPrize([
            'key' => $prizeIdentity = '2fc626a5-c57a-422d-8cc4-2164eb3b35e0',
        ]);
        $actual = $prize->getPrizeIdentity();
        self::assertEquals($prizeIdentity, $actual);
    }

    public function testWhenPassEmptyArray(): void
    {
        $this->expectException(PhysicalStaticDataPrizeException::class);
        $this->expectExceptionMessage(PhysicalStaticDataPrizeException::triedPassEmptyArray()->getMessage());
        new PhysicalStaticDataPrize([]);
    }
}
