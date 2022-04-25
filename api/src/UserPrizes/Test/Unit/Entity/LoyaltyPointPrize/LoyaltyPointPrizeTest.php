<?php

declare(strict_types=1);

namespace App\UserPrizes\Test\Unit\Entity\LoyaltyPointPrize;

use App\UserPrizes\Entity\AmountValue;
use App\UserPrizes\Entity\DeliveryStatus;
use App\UserPrizes\Entity\DeliveryStatusEnum;
use App\UserPrizes\Entity\LoyaltyPointPrize\LoyaltyPointPrize;
use App\UserPrizes\Entity\LoyaltyPointPrize\LoyaltyPointPrizeIdentity;
use App\UserPrizes\Test\Unit\UserPrizeBuilder;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\UserPrizes\Entity\LoyaltyPointPrize\LoyaltyPointPrize
 *
 * @internal
 */
final class LoyaltyPointPrizeTest extends TestCase
{
    public function testThatGetIdIsCorrect(): void
    {
        $manager = (new UserPrizeBuilder())->build();
        $prize = new LoyaltyPointPrize(
            $manager,
            $identity = LoyaltyPointPrizeIdentity::generate(),
            new AmountValue(random_int(1, 50000)),
            new DeliveryStatus(DeliveryStatusEnum::NEW)
        );
        self::assertEquals($identity->getValue(), $prize->getIdentity()->getValue());
    }

    public function testThatDeliveryStatusSetIsCorrect(): void
    {
        $manager = (new UserPrizeBuilder())->build();
        $prize = new LoyaltyPointPrize(
            $manager,
            LoyaltyPointPrizeIdentity::generate(),
            new AmountValue(random_int(1, 50000)),
            new DeliveryStatus(DeliveryStatusEnum::NEW)
        );

        $prize->setDeliveryStatus(new DeliveryStatus(DeliveryStatusEnum::CANCELED));
        self::assertEquals(DeliveryStatusEnum::CANCELED->value, $prize->getDeliveryStatus()->getStatus());
    }

    public function testThatAmountSetAndGetCorrect(): void
    {
        $manager = (new UserPrizeBuilder())->build();
        $prize = new LoyaltyPointPrize(
            $manager,
            LoyaltyPointPrizeIdentity::generate(),
            $amount = new AmountValue(random_int(1, 50000)),
            new DeliveryStatus(DeliveryStatusEnum::NEW)
        );
        self::assertEquals($amount->getValue(), $prize->getPrizeAmount()->getValue());
    }
}
