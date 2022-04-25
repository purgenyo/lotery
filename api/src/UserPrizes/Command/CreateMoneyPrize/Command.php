<?php

declare(strict_types=1);

namespace App\UserPrizes\Command\CreateMoneyPrize;

/**
 * @codeCoverageIgnore
 */
final class Command
{
    public function __construct(
        public readonly string $userId,
        public readonly string $moneyPrizeId,
    ) {
    }
}
