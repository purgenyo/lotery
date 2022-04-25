<?php

declare(strict_types=1);

namespace App\UserPrizes\Service\RandomPrize;

final class RandomPrize
{
    /**
     * @param CreateAndGeneratePrizeContentTemplate[] $randomList
     */
    public function __construct(private array $randomList)
    {
    }

    public function createAndGetRandomPrize(): array
    {
        if (\count($this->randomList) === 0) {
            return [];
        }
        $resultList = [];
        foreach ($this->randomList as $item) {
            $resultList[$item->getPrizeKey()] = [];
        }

        $prizeTemplate = $this->randomList[random_int(0, \count($this->randomList)-1)];

        $resultList[$prizeTemplate->getPrizeKey()] = $prizeTemplate->createAndGenerateContent();
        return $resultList;
    }
}
