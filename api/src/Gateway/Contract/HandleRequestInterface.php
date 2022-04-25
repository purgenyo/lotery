<?php

declare(strict_types=1);

namespace App\Gateway\Contract;

interface HandleRequestInterface
{
    public function handleRequest(): mixed;
}
