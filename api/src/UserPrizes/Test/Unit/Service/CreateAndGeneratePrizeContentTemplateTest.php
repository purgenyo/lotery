<?php

declare(strict_types=1);

namespace App\UserPrizes\Test\Unit\Service;

use App\UserPrizes\Service\RandomPrize\CreateAndGeneratePrizeContentTemplate;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\UserPrizes\Service\RandomPrize\CreateAndGeneratePrizeContentTemplate
 *
 * @internal
 */
final class CreateAndGeneratePrizeContentTemplateTest extends TestCase
{
    public function testThatCreateSuccess(): void
    {
        $class = new class() extends CreateAndGeneratePrizeContentTemplate {
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
                $this->content = ['item' => 'test'];
            }
        };

        self::assertArrayHasKey('item', $class->createAndGenerateContent());
    }
}
