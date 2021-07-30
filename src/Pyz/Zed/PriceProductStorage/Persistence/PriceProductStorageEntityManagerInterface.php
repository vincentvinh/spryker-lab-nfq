<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\PriceProductStorage\Persistence;

interface PriceProductStorageEntityManagerInterface
{
    /**
     * @param array $rates
     * @param \Pyz\Zed\PriceProductStorage\Persistence\PriceProductStorageQueryContainer $queryContainer
     * @param string $store
     *
     * @return mixed
     */
    public function updatePriceData(array $rates, PriceProductStorageQueryContainer $queryContainer, string $store);
}
