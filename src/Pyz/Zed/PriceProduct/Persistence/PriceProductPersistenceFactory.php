<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\PriceProduct\Persistence;

use Pyz\Zed\PriceProduct\PriceProductDependencyProvider;
use Spryker\Zed\PriceProduct\Persistence\PriceProductPersistenceFactory as SprykerPriceProductPersistenceFactory;

/**
 * Class PriceProductBusinessFactory
 *
 * @package Pyz\Zed\PriceProduct\Business
 */
class PriceProductPersistenceFactory extends SprykerPriceProductPersistenceFactory
{
     /**
      * @return \Spryker\Zed\Category\Dependency\Facade\CategoryToEventFacadeInterface
      */
    public function getEventFacade()
    {
        return $this->getProvidedDependency(PriceProductDependencyProvider::FACADE_EVENT);
    }
}
