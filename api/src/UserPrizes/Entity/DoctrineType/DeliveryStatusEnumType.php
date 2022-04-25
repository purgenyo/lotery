<?php

declare(strict_types=1);

namespace App\UserPrizes\Entity\DoctrineType;

use App\UserPrizes\Entity\DeliveryStatusEnum;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\IntegerType;

/**
 * @codeCoverageIgnore
 */
final class DeliveryStatusEnumType extends IntegerType
{
    public const NAME = 'UserPrizes_delivery_status_enum_type';

    public function convertToDatabaseValue($value, AbstractPlatform $platform): mixed
    {
        return $value instanceof DeliveryStatusEnum ? $value->value : $value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?DeliveryStatusEnum
    {
        return \is_int($value) ? DeliveryStatusEnum::from($value) : null;
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
