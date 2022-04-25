<?php

declare(strict_types=1);

namespace App\Gateway\Test\Unit;

use App\Gateway\Contract\HandleRequestInterface;
use App\Gateway\JsonResponseDecorator;

/**
 * @internal
 */
final class JsonResponseDecoratorTest extends \PHPUnit\Framework\TestCase
{
    public function testThatJsonGenerated(): void
    {
        $decoratorResponse = new JsonResponseDecorator(new class() implements HandleRequestInterface {
            public function handleRequest(): mixed
            {
                return ['test' => 'item'];
            }
        });
        self::assertEquals('{"test":"item"}', $decoratorResponse->handleRequest());
    }
}
