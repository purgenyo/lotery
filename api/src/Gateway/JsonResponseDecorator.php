<?php

declare(strict_types=1);

namespace App\Gateway;

use App\Gateway\Contract\HandleRequestInterface;

final class JsonResponseDecorator implements HandleRequestInterface
{
    public function __construct(private HandleRequestInterface $handleRequest)
    {
    }

    public function handleRequest(): string
    {
        return json_encode($this->handleRequest->handleRequest());
    }
}
