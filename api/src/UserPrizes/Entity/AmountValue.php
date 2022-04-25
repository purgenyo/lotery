<?php

declare(strict_types=1);

namespace App\UserPrizes\Entity;

use Webmozart\Assert\Assert;

final class AmountValue
{
    public function __construct(private int $value)
    {
        Assert::positiveInteger($value);
    }

    public function getValue(): int
    {
        return $this->value;
    }
}
