<?php

declare(strict_types=1);

namespace App\UserPrizes\Service\RandomPrize;

/** @codeCoverageIgnore  */
abstract class CreateAndGeneratePrizeContentTemplate implements CreatePrize, PrizeContent
{
    abstract public function getPrizeKey(): string;

    final public function createAndGenerateContent(): array
    {
        $this->createPrize();
        return $this->getContent();
    }
}
