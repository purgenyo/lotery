<?php

declare(strict_types=1);

namespace App\UserPrizes\Entity;

use App\UserPrizes\Contract\AggregateRoot;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;

/**
 * @Entity
 * @HasLifecycleCallbacks
 * @Table(name="user_prize_manager")
 */
class Manager implements AggregateRoot
{
    /**
     * @Id
     * @Column(type="prize_manager_id_type")
     */
    private ManagerId $id;

    /**
     * @Column(type="prize_manager_user_id_type")
     */
    private UserId $userId;

    public function __construct(ManagerId $id, UserId $userId)
    {
        $this->id = $id;
        $this->userId = $userId;
    }
}
