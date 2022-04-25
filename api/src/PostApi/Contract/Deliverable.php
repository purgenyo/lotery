<?php

declare(strict_types=1);

namespace App\PostApi\Contract;

interface Deliverable
{
    public function setPackageAsDelivered(): void;
}
