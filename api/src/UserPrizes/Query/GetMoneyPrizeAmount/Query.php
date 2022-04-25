<?php

declare(strict_types=1);

namespace App\UserPrizes\Query\GetMoneyPrizeAmount;

use Doctrine\ORM\EntityManagerInterface;

final class Query
{
    public function __construct(
        private EntityManagerInterface $em,
    ) {
    }

    public function handle(string $id): int
    {
        $stmt = $this->em->getConnection()
            ->createQueryBuilder()
            ->select('amount')
            ->from('user_prize_money_prize')
            ->where('id = :id')
            ->setParameter('id', $id)
            ->setMaxResults(1)
            ->executeQuery();

        return (int)$stmt->fetchOne();
    }
}
