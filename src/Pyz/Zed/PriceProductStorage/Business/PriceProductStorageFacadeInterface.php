<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\PriceProductStorage\Business;

/**
 * Interface PriceProductStorageFacadeInterface
 *
 * @package Pyz\Zed\PriceProductStorage\Business
 */
interface PriceProductStorageFacadeInterface
{
    /**
     * @return void
     */
    public function updatePriceProductConcreteStorage();
}
