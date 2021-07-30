<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\PriceProductStorage\Business;

use Spryker\Zed\PriceProductStorage\Business\PriceProductStorageFacade as SprykerPriceProductStorageFacade;

/**
 * Class PriceProductStorageFacade
 *
 * @package Pyz\Zed\PriceProductStorage\Business
 *
 * @method \Pyz\Zed\PriceProductStorage\Business\PriceProductStorageBusinessFactory getFactory()
 */
class PriceProductStorageFacade extends SprykerPriceProductStorageFacade implements PriceProductStorageFacadeInterface
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
