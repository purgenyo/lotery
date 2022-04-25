<?php

declare(strict_types=1);

namespace App\UserPrizes\Entity\DoctrineType;

use App\UserPrizes\Entity\LoyaltyPointPrize\LoyaltyPointPrizeIdentity;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType;

/**
 * @codeCoverageIgnore
 */
final class LoyaltyPointPrizeIdentityType extends GuidType
{
    public const NAME = 'UserPrizes_LoyaltyPointPrize_id';

    public function convertToDatabaseValue($value, AbstractPlatform $platform): mixed
    {
        return $value instanceof LoyaltyPointPrizeIdentity ? $value->getValue() : $value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?LoyaltyPointPrizeIdentity
    {
        return !empty($value) ? new LoyaltyPointPrizeIdentity((string)$value) : null;
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
