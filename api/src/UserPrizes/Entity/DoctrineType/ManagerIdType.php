<?php

declare(strict_types=1);

namespace App\UserPrizes\Entity\DoctrineType;

use App\UserPrizes\Entity\ManagerId;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType;

/**
 * @codeCoverageIgnore
 */
final class ManagerIdType extends GuidType
{
    public const NAME = 'prize_manager_id_type';

    public function convertToDatabaseValue($value, AbstractPlatform $platform): mixed
    {
        return $value instanceof ManagerId ? $value->getValue() : $value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?ManagerId
    {
        return !empty($value) ? new ManagerId((string)$value) : null;
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
