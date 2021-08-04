<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\PriceProduct\Persistence;

interface PriceProductEntityManagerInterface
{
    /**
     * @param string $currentCurrency
     * @param array $rates
     * @param int $store
     *
     * @return mixed
     */
    public function updatePriceData(string $currentCurrency, array $rates, int $store);
}
