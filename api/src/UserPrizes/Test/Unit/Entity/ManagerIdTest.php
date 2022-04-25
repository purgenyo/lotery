<?php

declare(strict_types=1);

namespace App\UserPrizes\Test\Unit\Entity;

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
        $object = new ManagerId($stringValue = (string)Uuid::v4());
        self::assertEquals($stringValue, $object->getValue());
        self::assertEquals($stringValue, (string)$object);
    }

    public function testThatGenerateSuccess(): void
    {
        $object = ManagerId::generate();
        self::assertInstanceOf(ManagerId::class, $object);
        self::assertTrue(Uuid::isValid($object->getValue()));
    }
}
