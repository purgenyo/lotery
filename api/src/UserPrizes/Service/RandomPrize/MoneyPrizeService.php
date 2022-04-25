<?php

declare(strict_types=1);

namespace App\UserPrizes\Service\RandomPrize;

use App\Auth\Contract\UserIdentityInterface;
use App\UserPrizes\Command\CreateMoneyPrize\Command as CreateMoneyPrizeCommand;
use App\UserPrizes\Command\CreateMoneyPrize\Handler as CreateMoneyPrizeHandler;
use App\UserPrizes\Query\GetMoneyPrizeAmount\Query;
use Exception;
use Symfony\Component\Uid\Uuid;

final class MoneyPrizeService extends CreateAndGeneratePrizeContentTemplate
{
    private const MONEY_PRIZE = 'moneyPrize';

    private ?string $moneyPrizeId = null;

    public function __construct(
        private UserIdentityInterface $userIdentity,
        private CreateMoneyPrizeHandler $createMoneyPrizeHandler,
        private Query $query,
    ) {
    }

    public function getPrizeKey(): string
    {
        return self::MONEY_PRIZE;
    }

    public function getContent(): array
    {
        if ($this->moneyPrizeId === null) {
            throw new Exception('moneyPrizeId did not generate');
        }
        return [
            'id' => $this->moneyPrizeId,
            'amount' => $this->query->handle($this->moneyPrizeId),
        ];
    }

    public function createPrize(): void
    {
        $userId = $this->userIdentity->getUserIdentity();
        if ($userId === null) {
            throw new Exception('User identity not found');
        }
        $this->createMoneyPrizeHandler->handle(new CreateMoneyPrizeCommand(
            $userId,
            $this->moneyPrizeId = (string)Uuid::v4(),
        ));
    }
}
