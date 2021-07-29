<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\PriceProductStorage\Business;

use Pyz\Zed\PriceProductStorage\PriceProductStorageDependencyProvider;
use Spryker\Zed\PriceProductStorage\Business\PriceProductStorageBusinessFactory as SprykerPriceProductStorageBusinessFactory;

/**
 * Class PriceProductStorageBusinessFactory
 *
 * @package Pyz\Zed\PriceProductStorage\Business
 */
class PriceProductStorageBusinessFactory extends SprykerPriceProductStorageBusinessFactory
{
    /**
     * @return \Spryker\Zed\AvailabilityGui\Dependency\Facade\AvailabilityToStoreFacadeInterface
     */
    public function getStoreFacade()
    {
        return $this->getProvidedDependency(PriceProductStorageDependencyProvider::FACADE_STORE);
    }

    /**
     * @return \Pyz\Zed\PriceProductStorage\Business\RateExchangeUpdater
     */
    public function createRateExchangeUpdater()
    {
        return new RateExchangeUpdater(
            $this->getStoreFacade()->getCurrentStore(),
            $this->getQueryContainer(),
            $this->getEntityManager()
        );
    }
}
