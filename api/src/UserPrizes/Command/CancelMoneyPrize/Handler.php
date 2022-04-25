<?php

declare(strict_types=1);

namespace App\UserPrizes\Command\CancelMoneyPrize;

use App\UserPrizes\Entity\Manager;
use App\UserPrizes\Entity\MoneyPrize\MoneyPrizeIdentity;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

final class Handler
{
    /**
     * @param EntityManagerInterface $entityManager
     * @param EntityRepository<Manager> $repository
     */
    public function __construct(
        private EntityManagerInterface $entityManager,
        private EntityRepository $repository,
    ) {
    }

    public function handle(Command $command): void
    {
        $manager = $this->repository->findOneBy(['userId' => $command->userId]);
        if ($manager === null) {
            return;
        }
        $manager->cancelMoneyPrize(new MoneyPrizeIdentity($command->moneyPrizeId));
        $this->entityManager->persist($manager);
        $this->entityManager->flush();
    }
}
