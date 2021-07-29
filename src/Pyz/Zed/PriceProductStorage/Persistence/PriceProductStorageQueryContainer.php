<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\PriceProductStorage\Persistence;

use Spryker\Zed\PriceProductStorage\Persistence\PriceProductStorageQueryContainer as SprykerPriceProductStorageQueryContainer;

class PriceProductStorageQueryContainer extends SprykerPriceProductStorageQueryContainer implements PriceProductStorageQueryContainerInterface
{
    /**
     * @param string $store
     *
     * @return \Orm\Zed\PriceProductStorage\Persistence\SpyPriceProductConcreteStorageQuery
     */
    public function queryPriceConcreteStorageByStore(string $store)
    {
        return $this->getFactory()
            ->createSpyPriceConcreteStorageQuery()
            ->filterByStore($store);
    }
}
