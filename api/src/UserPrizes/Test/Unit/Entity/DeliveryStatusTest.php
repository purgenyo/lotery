<?php

declare(strict_types=1);

namespace App\UserPrizes\Test\Unit\Entity;

use App\UserPrizes\Entity\DeliveryStatus;
use App\UserPrizes\Entity\DeliveryStatusEnum;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class DeliveryStatusTest extends TestCase
{
    public function testThatSuccess(): void
    {
        $deliveryStatus = new DeliveryStatus(DeliveryStatusEnum::NEW);
        self::assertEquals(DeliveryStatusEnum::NEW->value, $deliveryStatus->getStatus());
    }
}
