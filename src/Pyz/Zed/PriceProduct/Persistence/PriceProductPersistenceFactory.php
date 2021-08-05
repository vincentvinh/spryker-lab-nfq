<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\PriceProduct\Persistence;

use Spryker\Shared\Store\Dependency\Adapter\StoreToStoreInterface;
use Spryker\Zed\PriceProduct\Persistence\PriceProductPersistenceFactory as SprykerPriceProductPersistenceFactory;
use Spryker\Zed\Store\StoreDependencyProvider;

/**
 * Class PriceProductBusinessFactory
 *
 * @package Pyz\Zed\PriceProduct\Business
 */
class PriceProductPersistenceFactory extends SprykerPriceProductPersistenceFactory
{
    /**
     * @return \Spryker\Shared\Store\Dependency\Adapter\StoreToStoreInterface
     */
    public function getStore(): StoreToStoreInterface
    {
        return $this->getProvidedDependency(StoreDependencyProvider::STORE);
    }
}
