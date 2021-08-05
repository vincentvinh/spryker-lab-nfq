<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\PriceProduct\Business;

/**
 * Interface PriceProductFacadeInterface
 *
 * @package Pyz\Zed\PriceProduct\Business
 */
interface PriceProductFacadeInterface
{
    /**
     * @param array $currency
     *
     * @return void
     */
    public function updatePriceProduct(array $currency);
}
