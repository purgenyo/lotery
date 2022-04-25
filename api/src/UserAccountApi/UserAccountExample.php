<?php

declare(strict_types=1);

namespace App\UserAccountApi;

use App\UserAccountApi\Contract\SendAmount;

final class UserAccountExample implements SendAmount
{
    public function sendAmount(int $amount): void
    {
    }
}
