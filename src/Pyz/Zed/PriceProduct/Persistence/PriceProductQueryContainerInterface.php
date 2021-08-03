<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\PriceProduct\Persistence;

interface PriceProductQueryContainerInterface
{
    /**
     * @param int $store
     * @param string $currency
     *
     * @return mixed
     */
    public function queryPriceProductStoreByStoreAndCurrency(int $store, string $currency);
}
