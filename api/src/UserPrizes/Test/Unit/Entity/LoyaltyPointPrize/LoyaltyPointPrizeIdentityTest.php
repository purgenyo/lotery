<?php

declare(strict_types=1);

namespace App\UserPrizes\Test\Unit\Entity\LoyaltyPointPrize;

use App\UserPrizes\Entity\LoyaltyPointPrize\LoyaltyPointPrizeIdentity;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

/**
 * @covers \App\UserPrizes\Entity\LoyaltyPointPrize\LoyaltyPointPrizeIdentity
 *
 * @internal
 */
final class LoyaltyPointPrizeIdentityTest extends TestCase
{
    public function testThatCreateSuccess(): void
    {
        $object = new LoyaltyPointPrizeIdentity($stringValue = (string)Uuid::v4());
        self::assertEquals($stringValue, $object->getValue());
        self::assertEquals($stringValue, (string)$object);
    }

    public function testThatGenerateSuccess(): void
    {
        $object = LoyaltyPointPrizeIdentity::generate();
        self::assertInstanceOf(LoyaltyPointPrizeIdentity::class, $object);
        self::assertTrue(Uuid::isValid($object->getValue()));
    }

    public function testThatIdentityIsEquals(): void
    {
        $moneyPrizeOne = new LoyaltyPointPrizeIdentity($uuid = (string)Uuid::v4());
        self::assertTrue($moneyPrizeOne->isEqualTo(new LoyaltyPointPrizeIdentity($uuid)));
    }
}
