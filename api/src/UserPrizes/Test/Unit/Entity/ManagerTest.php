<?php

declare(strict_types=1);

namespace App\UserPrizes\Test\Unit\Entity;

use App\UserPrizes\Contract\DomainException;
use App\UserPrizes\Entity\AmountValue;
use App\UserPrizes\Entity\DeliveryStatusEnum;
use App\UserPrizes\Entity\LoyaltyPointPrize\LoyaltyPointPrizeIdentity;
use App\UserPrizes\Entity\MoneyPrize\MoneyPrizeIdentity;
use App\UserPrizes\Test\Unit\UserPrizeBuilder;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

/**
 * @covers \App\UserPrizes\Entity\Manager
 *
 * @internal
 */
final class ManagerTest extends TestCase
{
    public function testThatDeliveryStatusChangedToSendToUserSuccess(): void
    {
        $manager = (new UserPrizeBuilder())->build();
        $manager->addMoneyPrize(
            $moneyIdentity = MoneyPrizeIdentity::generate(),
            new AmountValue(random_int(1, 50000)),
        );
        $manager->sendToUserMoneyPrize($moneyIdentity);
        self::assertEquals(
            DeliveryStatusEnum::SEND_TO_USER->value,
            $manager->getMoneyPrize($moneyIdentity)->getDeliveryStatus()->getStatus()
        );
    }

    public function testThatMoneyPrizeWasNotFound(): void
    {
        $this->expectException(DomainException::class);
        $manager = (new UserPrizeBuilder())->build();
        $manager->sendToUserMoneyPrize(new MoneyPrizeIdentity((string)Uuid::v4()));
    }

    public function testThatGetMoneyPrizeIsCorrect(): void
    {
        $manager = (new UserPrizeBuilder())->build();
        $manager->addMoneyPrize(
            $moneyIdentity = MoneyPrizeIdentity::generate(),
            new AmountValue(random_int(1, 50000)),
        );
        $moneyPrize = $manager->getMoneyPrize($moneyIdentity);
        self::assertEquals($moneyIdentity->getValue(), $moneyPrize->getIdentity()->getValue());
    }

    public function testThatGetMoneyPrizeWasNotFound(): void
    {
        $manager = (new UserPrizeBuilder())->build();
        $this->expectException(DomainException::class);
        $manager->getMoneyPrize(new MoneyPrizeIdentity((string)Uuid::v4()));
    }

    public function testThatCancelMoneyPrizeIsCorrect(): void
    {
        $manager = (new UserPrizeBuilder())->build();
        $manager->addMoneyPrize(
            $moneyIdentity = MoneyPrizeIdentity::generate(),
            new AmountValue(random_int(1, 50000)),
        );
        $moneyPrize = $manager->getMoneyPrize($moneyIdentity);
        self::assertEquals(DeliveryStatusEnum::NEW->value, $moneyPrize->getDeliveryStatus()->getStatus());
        $manager->cancelMoneyPrize($moneyIdentity);
        self::assertEquals(DeliveryStatusEnum::CANCELED->value, $moneyPrize->getDeliveryStatus()->getStatus());
    }

    public function testThatMoneyPrizeWasNotFoundWhenCancelMoneyPrize(): void
    {
        $manager = (new UserPrizeBuilder())->build();
        $this->expectException(DomainException::class);
        $manager->cancelMoneyPrize(new MoneyPrizeIdentity((string)Uuid::v4()));
    }

    public function testThatAddAndGetLoyaltyPrizeSuccess(): void
    {
        $manager = (new UserPrizeBuilder())->build();
        $manager->addLoyalPrize(
            $prize = LoyaltyPointPrizeIdentity::generate(),
            new AmountValue(random_int(1, 50000)),
        );
        self::assertEquals($prize->getValue(), $manager->getLoyalPrize($prize)->getIdentity()->getValue());
    }

    public function testThatLoyaltyPrizeWasNotFoundWhenGet(): void
    {
        $manager = (new UserPrizeBuilder())->build();
        $this->expectException(DomainException::class);
        $manager->getLoyalPrize(LoyaltyPointPrizeIdentity::generate());
    }
}
