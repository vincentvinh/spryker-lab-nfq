<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\PriceProduct\Business;

interface RateExchangeUpdaterInterface
{
    /**
     * @param array $currencies
     *
     * @return void
     */
    public function execute(array $currencies);
}
