<?php

declare(strict_types=1);

namespace App\UserPrizes\Entity\DoctrineType;

use App\UserPrizes\Entity\AmountValue;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\IntegerType;

/**
 * @codeCoverageIgnore
 */
final class AmountType extends IntegerType
{
    public const NAME = 'UserPrizes_MoneyPrize_amount_type';

    public function convertToDatabaseValue($value, AbstractPlatform $platform): mixed
    {
        return $value instanceof AmountValue ? $value->getValue() : $value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?AmountValue
    {
        return \is_int($value) ? new AmountValue($value) : null;
    }

    public function getName(): string
    {
        return self::NAME;
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }
}
