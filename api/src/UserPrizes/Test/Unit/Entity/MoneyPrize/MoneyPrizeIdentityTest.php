<?php

declare(strict_types=1);

namespace App\UserPrizes\Test\Unit\Entity\MoneyPrize;

use App\UserPrizes\Entity\MoneyPrize\MoneyPrizeIdentity;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

/**
 * @covers \App\UserPrizes\Entity\MoneyPrize\MoneyPrizeIdentity
 *
 * @internal
 */
final class MoneyPrizeIdentityTest extends TestCase
{
    public function testThatCreateSuccess(): void
    {
        $object = new MoneyPrizeIdentity($stringValue = (string)Uuid::v4());
        self::assertEquals($stringValue, $object->getValue());
        self::assertEquals($stringValue, (string)$object);
    }

    public function testThatGenerateSuccess(): void
    {
        $object = MoneyPrizeIdentity::generate();
        self::assertInstanceOf(MoneyPrizeIdentity::class, $object);
        self::assertTrue(Uuid::isValid($object->getValue()));
    }

    public function testThatIdentityIsEquals(): void
    {
        $moneyPrize = new MoneyPrizeIdentity($uuid = (string)Uuid::v4());
        self::assertTrue($moneyPrize->isEqualTo(new MoneyPrizeIdentity($uuid)));
    }
}
