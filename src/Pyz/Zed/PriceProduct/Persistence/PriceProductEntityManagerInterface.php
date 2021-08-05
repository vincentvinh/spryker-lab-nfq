<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\PriceProduct\Persistence;

use Generated\Shared\Transfer\StoreTransfer;

interface PriceProductEntityManagerInterface
{
    /**
     * @param \Generated\Shared\Transfer\StoreTransfer $currentStore
     * @param array $rates
     *
     * @return mixed
     */
    public function updatePriceData(StoreTransfer $currentStore, array $rates);
}
