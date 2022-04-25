<?php

declare(strict_types=1);

namespace App\UserPrizes\Console;

use App\UserPrizes\Command\SendMoneyPrizeToUser\Command;
use App\UserPrizes\Command\SendMoneyPrizeToUser\Handler;
use App\UserPrizes\Entity\Manager;
use App\UserPrizes\Entity\MoneyPrize\MoneyPrize;
use Doctrine\ORM\EntityManagerInterface;

final class SendMoneyPrizesToUsers implements RunConsoleCommand
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private Handler $handler,
    ) {
    }

    public function runCommand(): void
    {
        $qb = $this->entityManager->createQueryBuilder();

        $prizes = $qb->select('manager, moneyPrizes')
            ->from(Manager::class, 'manager')
            ->join('manager.moneyPrizes', 'moneyPrizes')
            ->where('moneyPrizes.deliveryStatus.statusEnum = 1')
            ->setMaxResults(5000)
            ->getQuery()
            ->getResult();

        /** @var Manager $manager */
        foreach ($prizes as $manager) {
            /** @var MoneyPrize $moneyPrize */
            foreach ($manager->getMoneyPrizes() as $moneyPrize) {
                $this->handler->handle(
                    new Command(
                        $manager->getUserIdentity()->getValue(),
                        $moneyPrize->getIdentity()->getValue()
                    )
                );
            }
        }
    }
}
