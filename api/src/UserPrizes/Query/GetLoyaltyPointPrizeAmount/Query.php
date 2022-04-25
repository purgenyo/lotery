<?php

declare(strict_types=1);

namespace App\UserPrizes\Query\GetLoyaltyPointPrizeAmount;

use Doctrine\ORM\EntityManagerInterface;

final class Query
{
    public function __construct(
        private EntityManagerInterface $em,
    ) {
    }

    public function handle(string $identity): int
    {
        $stmt = $this->em->getConnection()
            ->createQueryBuilder()
            ->select('amount')
            ->from('user_prize_loyalty_point')
            ->where('id = :id')
            ->setParameter('id', $identity)
            ->setMaxResults(1)
            ->executeQuery();

        return (int)$stmt->fetchOne();
    }
}
