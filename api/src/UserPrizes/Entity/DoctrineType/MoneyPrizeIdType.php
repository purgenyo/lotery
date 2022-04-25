<?php

declare(strict_types=1);

namespace App\UserPrizes\Entity\DoctrineType;

use App\UserPrizes\Entity\MoneyPrize\MoneyPrizeIdentity;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType;

/**
 * @codeCoverageIgnore
 */
final class MoneyPrizeIdType extends GuidType
{
    public const NAME = 'UserPrizes_MoneyPrize_id';

    public function convertToDatabaseValue($value, AbstractPlatform $platform): mixed
    {
        return $value instanceof MoneyPrizeIdentity ? $value->getValue() : $value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?MoneyPrizeIdentity
    {
        return !empty($value) ? new MoneyPrizeIdentity((string)$value) : null;
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
