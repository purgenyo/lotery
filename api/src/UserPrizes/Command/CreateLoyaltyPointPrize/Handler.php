<?php

declare(strict_types=1);

namespace App\UserPrizes\Command\CreateLoyaltyPointPrize;

use App\PrizeApi\Contract\AmountPrize;
use App\UserPrizes\Entity\AmountValue;
use App\UserPrizes\Entity\LoyaltyPointPrize\LoyaltyPointPrizeIdentity;
use App\UserPrizes\Entity\Manager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

final class Handler
{
    /**
     * @param EntityManagerInterface $entityManager
     * @param EntityRepository<Manager> $repository
     * @param AmountPrize $amountPrize
     */
    public function __construct(
        private EntityManagerInterface $entityManager,
        private EntityRepository $repository,
        private AmountPrize $amountPrize,
    ) {
    }

    public function handle(Command $command): void
    {
        $manager = $this->repository->findOneBy(['userId' => $command->userId]);
        if ($manager === null) {
            return;
        }
        $manager->addLoyalPrize(
            new LoyaltyPointPrizeIdentity($command->loyaltyPointPrizeId),
            new AmountValue(
                $this->amountPrize->getAmount()
            ),
        );
        $this->entityManager->persist($manager);
        $this->entityManager->flush();
    }
}
