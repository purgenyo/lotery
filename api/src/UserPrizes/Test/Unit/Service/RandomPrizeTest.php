<?php

declare(strict_types=1);

namespace App\UserPrizes\Test\Unit\Service;

use App\UserPrizes\Service\RandomPrize\CreateAndGeneratePrizeContentTemplate;
use App\UserPrizes\Service\RandomPrize\RandomPrize;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\UserPrizes\Service\RandomPrize\RandomPrize
 *
 * @internal
 */
final class RandomPrizeTest extends TestCase
{
    public function testThatPassEmptyArray(): void
    {
        $randomPrize = new RandomPrize([]);
        self::assertEquals([], $randomPrize->createAndGetRandomPrize());
    }

    public function testThatRandomPrizeCreated(): void
    {
        $randomPrize = new RandomPrize([
            new class() extends CreateAndGeneratePrizeContentTemplate {
                private array $content = [];

                public function getPrizeKey(): string
                {
                    return 'key';
                }

                public function getContent(): array
                {
                    return $this->content;
                }

                public function createPrize(): void
                {
                    $this->content = ['test' => 'item'];
                }
            },
        ]);

        $result = $randomPrize->createAndGetRandomPrize();
        self::assertArrayHasKey('key', $result);
        self::assertArrayHasKey('test', $result['key']);
        self::assertEquals('item', $result['key']['test']);
    }
}
