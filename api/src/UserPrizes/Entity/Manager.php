<?php

declare(strict_types=1);

namespace App\UserPrizes\Entity;

use App\UserPrizes\Contract\AggregateRoot;
use App\UserPrizes\Contract\DomainException;
use App\UserPrizes\Entity\LoyaltyPointPrize\LoyaltyPointPrize;
use App\UserPrizes\Entity\LoyaltyPointPrize\LoyaltyPointPrizeIdentity;
use App\UserPrizes\Entity\MoneyPrize\MoneyPrize;
use App\UserPrizes\Entity\MoneyPrize\MoneyPrizeIdentity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\UniqueConstraint;

/**
 * @Entity
 * @HasLifecycleCallbacks
 * @Table(
 *		name="user_prize_manager",
 *		uniqueConstraints={@UniqueConstraint(name="unique_user_id", columns={"userId"})}
 * )
 */
class Manager implements AggregateRoot
{
    /**
     * @Id
     * @Column(type="UserPrizes_manager_id_type")
     */
    private ManagerId $id;

    /**
     * @Column(type="UserPrizes_user_id_type")
     */
    private UserId $userId;

    /**
     * @var Collection<int, MoneyPrize>
     * @ORM\OneToMany(
     *     targetEntity="App\UserPrizes\Entity\MoneyPrize\MoneyPrize",
     *     cascade={"all"},
     *     mappedBy="manager",
     *     orphanRemoval=true
     * )
     * @ORM\JoinColumn(name="id", referencedColumnName="manager_id")
     */
    private Collection $moneyPrizes;

    /**
     * @var Collection<int, LoyaltyPointPrize>
     * @ORM\OneToMany(
     *     targetEntity="App\UserPrizes\Entity\LoyaltyPointPrize\LoyaltyPointPrize",
     *     cascade={"all"},
     *     mappedBy="manager",
     *     orphanRemoval=true
     * )
     * @ORM\JoinColumn(name="id", referencedColumnName="manager_id")
     */
    private Collection $loyaltyPointPrizes;

    public function __construct(ManagerId $id, UserId $userId)
    {
        $this->id = $id;
        $this->userId = $userId;
        $this->moneyPrizes = new ArrayCollection();
        $this->loyaltyPointPrizes = new ArrayCollection();
    }

    public function addMoneyPrize(MoneyPrizeIdentity $id, AmountValue $prizeAmount): void
    {
        $this->moneyPrizes->add(
            new MoneyPrize(
                $this,
                $id,
                $prizeAmount,
                new DeliveryStatus(DeliveryStatusEnum::NEW)
            ),
        );
    }

    public function getMoneyPrize(MoneyPrizeIdentity $id): MoneyPrize
    {
        $moneyPrize = $this->findMoneyPrizeById($id);
        if ($moneyPrize === null) {
            throw new DomainException('Money prize was not found');
        }

        return $moneyPrize;
    }

    public function addLoyalPrize(LoyaltyPointPrizeIdentity $id, AmountValue $prizeAmount): void
    {
        $this->loyaltyPointPrizes->add(
            new LoyaltyPointPrize(
                $this,
                $id,
                $prizeAmount,
                new DeliveryStatus(DeliveryStatusEnum::NEW)
            ),
        );
    }

    public function getLoyalPrize(LoyaltyPointPrizeIdentity $id): LoyaltyPointPrize
    {
        $loyalty = $this->findLoyaltyPrizeById($id);
        if ($loyalty === null) {
            throw new DomainException('Money prize was not found');
        }

        return $loyalty;
    }

    public function sendToUserMoneyPrize(MoneyPrizeIdentity $id): void
    {
        $moneyPrize = $this->findMoneyPrizeById($id);
        if ($moneyPrize === null) {
            throw new DomainException('Money prize was not found');
        }

        $moneyPrize->setDeliveryStatus(
            new DeliveryStatus(DeliveryStatusEnum::SEND_TO_USER)
        );
    }

    /**
     * @return  Collection<int, MoneyPrize>
     */
    public function getMoneyPrizes(): Collection
    {
        return $this->moneyPrizes;
    }

    public function cancelMoneyPrize(MoneyPrizeIdentity $id): void
    {
        $moneyPrize = $this->findMoneyPrizeById($id);
        if ($moneyPrize === null) {
            throw new DomainException('Money prize was not found');
        }

        $moneyPrize->setDeliveryStatus(
            new DeliveryStatus(DeliveryStatusEnum::CANCELED)
        );
    }

    public function getUserIdentity(): UserId
    {
        return $this->userId;
    }

    private function findMoneyPrizeById(MoneyPrizeIdentity $id): ?MoneyPrize
    {
        foreach ($this->moneyPrizes as $moneyPrize) {
            if ($moneyPrize->getIdentity()->isEqualTo($id)) {
                return $moneyPrize;
            }
        }

        return null;
    }

    private function findLoyaltyPrizeById(LoyaltyPointPrizeIdentity $id): ?LoyaltyPointPrize
    {
        foreach ($this->loyaltyPointPrizes as $loyaltyPointPrize) {
            if ($loyaltyPointPrize->getIdentity()->isEqualTo($id)) {
                return $loyaltyPointPrize;
            }
        }

        return null;
    }
}
