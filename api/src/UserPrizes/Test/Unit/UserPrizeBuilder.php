<?php

declare(strict_types=1);

namespace App\UserPrizes\Test\Unit;

use App\UserPrizes\Entity\AmountValue;
use App\UserPrizes\Entity\Manager;
use App\UserPrizes\Entity\ManagerId;
use App\UserPrizes\Entity\MoneyPrize\MoneyPrizeIdentity;
use App\UserPrizes\Entity\UserId;
use Symfony\Component\Uid\Uuid;

final class UserPrizeBuilder
{
    private ?string $userId = null;
    private ?string $managerId = null;
    private ?int $amountValue = null;
    private ?string $moneyPrizeIdentity = null;

    public function __construct()
    {
    }

    public function withUserId(string $userId): self
    {
        $cloned = clone $this;
        $cloned->userId = $userId;
        return $cloned;
    }

    public function withManagerId(string $managerId): self
    {
        $cloned = clone $this;
        $cloned->managerId = $managerId;
        return $cloned;
    }

    public function withMoneyPrizeAmountValue(int $amountValue): self
    {
        $cloned = clone $this;
        $cloned->amountValue = $amountValue;
        return $cloned;
    }

    public function withMoneyPrizeIdentity(string $moneyPrizeIdentity): self
    {
        $cloned = clone $this;
        $cloned->moneyPrizeIdentity = $moneyPrizeIdentity;
        return $cloned;
    }

    public function build(): Manager
    {
        $manager = new Manager(
            new ManagerId($this->managerId ?? (string)Uuid::v4()),
            new UserId($this->userId ?? (string)Uuid::v4()),
        );

        if ($this->amountValue !== null && $this->moneyPrizeIdentity !== null) {
            $manager->addMoneyPrize(
                new MoneyPrizeIdentity($this->moneyPrizeIdentity),
                new AmountValue($this->amountValue),
            );
        }

        return $manager;
    }
}
