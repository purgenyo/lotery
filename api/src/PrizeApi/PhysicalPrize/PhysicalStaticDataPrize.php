<?php

declare(strict_types=1);

namespace App\PrizeApi\PhysicalPrize;

use App\PrizeApi\Contract\PhysicalPrize as PhysicalPrizeInterface;
use App\PrizeApi\Exception\PhysicalStaticDataPrizeException;

final class PhysicalStaticDataPrize implements PhysicalPrizeInterface
{
    /**
     * @param string[] $constPrizeList
     *
     * @throws PhysicalStaticDataPrizeException
     */
    public function __construct(private array $constPrizeList)
    {
        if (\count($constPrizeList) === 0) {
            throw PhysicalStaticDataPrizeException::triedPassEmptyArray();
        }
    }

    public function getPrizeIdentity(): string
    {
        $this->constPrizeList = array_values($this->constPrizeList);
        return $this->constPrizeList[random_int(0, \count($this->constPrizeList)-1)];
    }
}
