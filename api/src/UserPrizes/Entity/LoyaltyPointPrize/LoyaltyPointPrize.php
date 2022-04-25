<?php

declare(strict_types=1);

namespace App\UserPrizes\Entity\LoyaltyPointPrize;

use App\UserPrizes\Entity\AmountValue;
use App\UserPrizes\Entity\DeliveryStatus;
use App\UserPrizes\Entity\Manager;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\UniqueConstraint;

/**
 * @ORM\Entity
 * @HasLifecycleCallbacks
 * @ORM\Table(
 *     name="user_prize_loyalty_point",
 *     uniqueConstraints={@UniqueConstraint(name="unique_id", columns={"id"})}
 * )
 */
class LoyaltyPointPrize
{
    /**
     * @Id
     * @Column(type="UserPrizes_LoyaltyPointPrize_id")
     */
    private LoyaltyPointPrizeIdentity $id;

    /**
     * @ORM\Embedded(class="App\UserPrizes\Entity\DeliveryStatus", columnPrefix=false)
     */
    private DeliveryStatus $deliveryStatus;

    /**
     * @Column(type="UserPrizes_MoneyPrize_amount_type")
     */
    private AmountValue $amount;

    /**
     * @ManyToOne(targetEntity="App\UserPrizes\Entity\Manager", inversedBy="loyaltyPointPrizes")
     */
    private Manager $manager;

    public function __construct(
        Manager $manager,
        LoyaltyPointPrizeIdentity $id,
        AmountValue $amount,
        DeliveryStatus $deliveryStatus,
    ) {
        $this->id = $id;
        $this->amount = $amount;
        $this->manager = $manager;
        $this->deliveryStatus = $deliveryStatus;
    }

    public function getIdentity(): LoyaltyPointPrizeIdentity
    {
        return $this->id;
    }

    public function setDeliveryStatus(DeliveryStatus $deliveryStatus): void
    {
        $this->deliveryStatus = $deliveryStatus;
    }

    public function getDeliveryStatus(): DeliveryStatus
    {
        return $this->deliveryStatus;
    }

    public function getPrizeAmount(): AmountValue
    {
        return $this->amount;
    }
}
