<?php

declare(strict_types=1);

namespace App\UserPrizes\Service\RandomPrize;

use App\Auth\Contract\UserIdentityInterface;
use App\UserPrizes\Command\CreateLoyaltyPointPrize\Command;
use App\UserPrizes\Command\CreateLoyaltyPointPrize\Handler;
use App\UserPrizes\Query\GetLoyaltyPointPrizeAmount\Query;
use Exception;
use Symfony\Component\Uid\Uuid;

final class LoyaltyPointPrizeService extends CreateAndGeneratePrizeContentTemplate
{
    private const LOYALTY_PRIZE = 'loyaltyPrize';

    private ?string $loyaltyPrizeId = null;

    public function __construct(
        private UserIdentityInterface $userIdentity,
        private Handler $handler,
        private Query $query,
    ) {
    }

    public function getPrizeKey(): string
    {
        return self::LOYALTY_PRIZE;
    }

    public function getContent(): array
    {
        if ($this->loyaltyPrizeId === null) {
            throw new Exception('moneyPrizeId did not generate');
        }
        return [
            'id' => $this->loyaltyPrizeId,
            'amount' => $this->query->handle($this->loyaltyPrizeId),
        ];
    }

    public function createPrize(): void
    {
        $userId = $this->userIdentity->getUserIdentity();
        if ($userId === null) {
            throw new Exception('User identity not found');
        }
        $this->handler->handle(new Command(
            $userId,
            $this->loyaltyPrizeId = (string)Uuid::v4(),
        ));
    }
}
