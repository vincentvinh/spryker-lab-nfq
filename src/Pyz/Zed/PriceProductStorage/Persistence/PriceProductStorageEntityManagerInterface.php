<?php

namespace Pyz\Zed\PriceProductStorage\Persistence;

use Spryker\Zed\Kernel\Persistence\AbstractQueryContainer;

interface PriceProductStorageEntityManagerInterface
{
    public function updatePriceData(array $rates, AbstractQueryContainer $queryContainer, string $store);
}
