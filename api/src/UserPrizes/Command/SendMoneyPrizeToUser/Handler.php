<?php

declare(strict_types=1);

namespace App\UserPrizes\Command\SendMoneyPrizeToUser;

use App\UserAccountApi\Contract\SendAmount;
use App\UserPrizes\Entity\DeliveryStatusEnum;
use App\UserPrizes\Entity\Manager;
use App\UserPrizes\Entity\MoneyPrize\MoneyPrizeIdentity;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

final class Handler
{
    /**
     * @param EntityManagerInterface $entityManager
     * @param EntityRepository<Manager> $repository
     * @param SendAmount $billApi
     */
    public function __construct(
        private EntityManagerInterface $entityManager,
        private EntityRepository $repository,
        private SendAmount $billApi,
    ) {
    }

    public function handle(Command $command): void
    {
        $manager = $this->repository->findOneBy([
            'userId' => $command->userId,
        ]);
        if ($manager === null) {
            return;
        }

        $prize = $manager->getMoneyPrize(new MoneyPrizeIdentity($command->moneyPrizeId));
        if ($prize->getDeliveryStatus()->getStatus() !== DeliveryStatusEnum::NEW->value) {
            return;
        }

        $this->billApi->sendAmount(
            $prize->getPrizeAmount()->getValue()
        );

        $manager->sendToUserMoneyPrize(new MoneyPrizeIdentity($command->moneyPrizeId));
        $this->entityManager->persist($manager);
        $this->entityManager->flush();
    }
}
