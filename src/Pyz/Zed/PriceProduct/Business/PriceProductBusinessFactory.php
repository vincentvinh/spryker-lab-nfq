<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\PriceProduct\Business;

use Pyz\Zed\PriceProduct\PriceProductDependencyProvider;
use Spryker\Zed\PriceProduct\Business\PriceProductBusinessFactory as SprykerPriceProductBusinessFactory;

/**
 * Class PriceProductBusinessFactory
 *
 * @package Pyz\Zed\PriceProduct\Business
 */
class PriceProductBusinessFactory extends SprykerPriceProductBusinessFactory
{
    /**
     * @return \Pyz\Zed\PriceProduct\Business\RateExchangeUpdater
     */
    public function createRateExchangeUpdater()
    {
        return new RateExchangeUpdater(
            $this->getStoreFacade(),
            $this->getQueryContainer(),
            $this->getEntityManager(),
            $this->getEventFacade()
        );
    }

    /**
     * @return \Spryker\Zed\Category\Dependency\Facade\CategoryToEventFacadeInterface
     */
    protected function getEventFacade()
    {
        return $this->getProvidedDependency(PriceProductDependencyProvider::FACADE_EVENT);
    }
}
