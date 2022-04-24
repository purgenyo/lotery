<?php

declare(strict_types=1);

namespace App\Auth\Contract;

interface UserIdentityInterface
{
    public function getUserIdentity(): string;
}
