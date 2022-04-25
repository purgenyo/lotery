<?php

declare(strict_types=1);

namespace App\UserPrizes\Entity;

enum DeliveryStatusEnum: int
{
    case NEW = 1;
    case SEND_TO_USER = 2;
    case CANCELED = 3;
}
