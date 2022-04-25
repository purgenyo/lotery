<?php

declare(strict_types=1);

namespace App\UserAccountApi\Contract;

interface SendAmount
{
    public function sendAmount(int $amount): void;
}
