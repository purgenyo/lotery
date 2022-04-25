<?php

declare(strict_types=1);

namespace App\UserPrizes\Test\Unit\Entity;

use App\UserPrizes\Entity\UserId;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

/**
 * @covers \App\UserPrizes\Entity\UserId
 *
 * @internal
 */
final class UserIdTest extends TestCase
{
    public function testThatCreateSuccess(): void
    {
        $userId = new UserId($stringValue = (string)Uuid::v4());
        self::assertEquals($stringValue, $userId->getValue());
        self::assertEquals($stringValue, (string)$userId);
    }

    public function testThatGenerateSuccess(): void
    {
        $userId = UserId::generate();
        self::assertInstanceOf(UserId::class, $userId);
        self::assertTrue(Uuid::isValid($userId->getValue()));
    }
}
