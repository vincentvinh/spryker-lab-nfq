<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\PriceProductStorage\Business;

/**
 * Class PriceProductStorageFacade
 *
 * @package Pyz\Zed\PriceProductStorage\Business
 */
class PriceProductStorageFacade extends \Spryker\Zed\PriceProductStorage\Business\PriceProductStorageFacade implements PriceProductStorageFacadeInterface
{
    /**
     * @return void
     */
    public function updatePriceProductConcreteStorage()
    {
        $handler = $this->getFactory()->createRateExchangeUpdater();
        $handler->execute();
    }
}
