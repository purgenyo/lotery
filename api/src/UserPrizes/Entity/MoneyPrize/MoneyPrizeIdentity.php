<?php

declare(strict_types=1);

namespace App\UserPrizes\Entity\MoneyPrize;

use Symfony\Component\Uid\Uuid;
use Webmozart\Assert\Assert;

final class MoneyPrizeIdentity
{
    public function __construct(private string $value)
    {
        Assert::uuid($value);
        $this->value = mb_strtolower($value);
    }

    public function __toString(): string
    {
        return $this->getValue();
    }

    public static function generate(): self
    {
        return new self((string)Uuid::v4());
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function isEqualTo(self $id): bool
    {
        return $this->getValue() === $id->getValue();
    }
}
