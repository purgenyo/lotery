<?php

declare(strict_types=1);

namespace App\Auth;

use App\Auth\Contract\UserIdentityInterface;

/**
 * @codeCoverageIgnore
 */
final class UserIdentityExample implements UserIdentityInterface
{
    public function getUserIdentity(): ?string
    {
        return '6e6662fd-76cd-4abb-8fec-a9b7ca95e08e';
    }
}
