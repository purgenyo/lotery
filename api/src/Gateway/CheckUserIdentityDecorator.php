<?php

declare(strict_types=1);

namespace App\Gateway;

use App\Auth\Contract\UserIdentityInterface;
use App\Gateway\Contract\HandleRequestInterface;
use App\Gateway\Exception\NotAuthorizedException;
use App\UserPrizes\Command\InitManagerCommand\Command as InitManagerCommand;
use App\UserPrizes\Command\InitManagerCommand\Handler as InitManagerCommandHandler;

final class CheckUserIdentityDecorator implements HandleRequestInterface
{
    public function __construct(
        private InitManagerCommandHandler $initManagerCommandHandler,
        private UserIdentityInterface $userIdentity,
        private HandleRequestInterface $handleRequest,
    ) {
    }

    public function handleRequest(): mixed
    {
        $userId = $this->userIdentity->getUserIdentity();
        if ($userId === null) {
            throw new NotAuthorizedException('User is not authorized');
        }
        $this->initManagerCommandHandler->handle(new InitManagerCommand($userId));
        return $this->handleRequest->handleRequest();
    }
}
