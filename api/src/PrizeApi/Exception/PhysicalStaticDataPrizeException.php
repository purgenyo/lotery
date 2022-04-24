<?php

declare(strict_types=1);

namespace App\PrizeApi\Exception;

use Exception;

final class PhysicalStaticDataPrizeException extends Exception
{
    public static function triedPassEmptyArray(): self
    {
        return new self(
            'Tried pass empty array, but empty array not found'
        );
    }
}
