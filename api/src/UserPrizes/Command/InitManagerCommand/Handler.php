<?php

declare(strict_types=1);

namespace App\UserPrizes\Command\InitManagerCommand;

use App\UserPrizes\Entity\Manager;
use App\UserPrizes\Entity\ManagerId;
use App\UserPrizes\Entity\UserId;
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
        if ($this->repository->findOneBy(['userId' => $command->userId]) !== null) {
            return;
        }
        $manager = new Manager(
            ManagerId::generate(),
            new UserId($command->userId),
        );
        $this->entityManager->persist($manager);
        $this->entityManager->flush();
    }
}
