<?php

declare(strict_types=1);

namespace App\UserPrizes\Test\Unit;

use App\UserPrizes\Entity\ManagerId;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

/**
 * @covers \App\UserPrizes\Entity\ManagerId
 *
 * @internal
 */
final class ManagerIdTest extends TestCase
{
    public function testThatCreateSuccess(): void
    {
        $userId = new ManagerId($stringValue = (string)Uuid::v4());
        self::assertEquals($stringValue, $userId->getValue());
        self::assertEquals($stringValue, (string)$userId);
    }

    public function testThatGenerateSuccess(): void
    {
        $userId = ManagerId::generate();
        self::assertInstanceOf(ManagerId::class, $userId);
        self::assertTrue(Uuid::isValid($userId->getValue()));
    }
}
