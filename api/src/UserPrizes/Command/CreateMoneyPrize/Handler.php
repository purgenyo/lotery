<?php

declare(strict_types=1);

namespace App\UserPrizes\Command\CreateMoneyPrize;

use App\PrizeApi\Contract\AmountPrize;
use App\UserPrizes\Entity\AmountValue;
use App\UserPrizes\Entity\Manager;
use App\UserPrizes\Entity\MoneyPrize\MoneyPrizeIdentity;
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
        $manager->addMoneyPrize(
            new MoneyPrizeIdentity($command->moneyPrizeId),
            new AmountValue(
                $this->amountPrize->getAmount()
            ),
        );
        $this->entityManager->persist($manager);
        $this->entityManager->flush();
    }
}
