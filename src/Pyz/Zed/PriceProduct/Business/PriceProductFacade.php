<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\PriceProduct\Business;

use Spryker\Zed\PriceProduct\Business\PriceProductFacade as SprykerPriceProductFacade;

/**
 * Class PriceProductFacade
 *
 * @package Pyz\Zed\PriceProduct\Business
 *
 * @method \Pyz\Zed\PriceProduct\Business\PriceProductBusinessFactory getFactory()
 */
class PriceProductFacade extends SprykerPriceProductFacade implements PriceProductFacadeInterface
{
    /**
     * @param array $currency
     *
     * @return void
     */
    public function updatePriceProduct(array $currency)
    {
        $handler = $this->getFactory()->createRateExchangeUpdater();
        $handler->execute($currency);
    }
}
