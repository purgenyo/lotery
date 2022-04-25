<?php

declare(strict_types=1);

namespace App\UserPrizes\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable
 */
final class DeliveryStatus
{
    /**
     * @ORM\Column(
     *     type="UserPrizes_delivery_status_enum_type",
     *     options={"default": 1}
     *	 )
     */
    public DeliveryStatusEnum $statusEnum;

    public function __construct(DeliveryStatusEnum $statusEnum)
    {
        $this->statusEnum = $statusEnum;
    }

    public function getStatus(): int
    {
        return $this->statusEnum->value;
    }
}
