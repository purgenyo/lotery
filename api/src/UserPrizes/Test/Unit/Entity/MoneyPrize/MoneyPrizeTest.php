<?php

declare(strict_types=1);

namespace App\UserPrizes\Test\Unit\Entity\MoneyPrize;

use App\UserPrizes\Entity\AmountValue;
use App\UserPrizes\Entity\DeliveryStatus;
use App\UserPrizes\Entity\DeliveryStatusEnum;
use App\UserPrizes\Entity\MoneyPrize\MoneyPrize;
use App\UserPrizes\Entity\MoneyPrize\MoneyPrizeIdentity;
use App\UserPrizes\Test\Unit\UserPrizeBuilder;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\UserPrizes\Entity\MoneyPrize\MoneyPrize
 *
 * @internal
 */
final class MoneyPrizeTest extends TestCase
{
    public function testThatGetIdIsCorrect(): void
    {
        $manager = (new UserPrizeBuilder())->build();
        $moneyPrize = new MoneyPrize(
            $manager,
            $moneyIdentity = MoneyPrizeIdentity::generate(),
            new AmountValue(random_int(1, 50000)),
            new DeliveryStatus(DeliveryStatusEnum::NEW)
        );
        self::assertEquals($moneyIdentity->getValue(), $moneyPrize->getIdentity()->getValue());
    }

    public function testThatDeliveryStatusSetIsCorrect(): void
    {
        $manager = (new UserPrizeBuilder())->build();
        $moneyPrize = new MoneyPrize(
            $manager,
            MoneyPrizeIdentity::generate(),
            new AmountValue(random_int(1, 50000)),
            new DeliveryStatus(DeliveryStatusEnum::NEW)
        );

        $moneyPrize->setDeliveryStatus(new DeliveryStatus(DeliveryStatusEnum::CANCELED));
        self::assertEquals(DeliveryStatusEnum::CANCELED->value, $moneyPrize->getDeliveryStatus()->getStatus());
    }

    public function testThatAmountSetAndGetCorrect(): void
    {
        $manager = (new UserPrizeBuilder())->build();
        $prize = new MoneyPrize(
            $manager,
            MoneyPrizeIdentity::generate(),
            $amount = new AmountValue(random_int(1, 50000)),
            new DeliveryStatus(DeliveryStatusEnum::NEW)
        );
        self::assertEquals($amount->getValue(), $prize->getPrizeAmount()->getValue());
    }
}
