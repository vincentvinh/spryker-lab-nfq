<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Pyz\Zed\PriceProductStorage\Persistence;

class PriceProductStorageQueryContainer extends \Spryker\Zed\PriceProductStorage\Persistence\PriceProductStorageQueryContainer
implements PriceProductStorageQueryContainerInterface {
    /**
     * {@inheritDoc}
     *
     * @param int[] $productConcreteIds
     *
     * @return \Orm\Zed\PriceProductStorage\Persistence\SpyPriceProductConcreteStorageQuery
     * @throws \Spryker\Zed\Propel\Business\Exception\AmbiguousComparisonException
     * @api
     *
     */
    public function queryPriceConcreteStorageByStore(string $store)
    {
        return $this->getFactory()
            ->createSpyPriceConcreteStorageQuery()
            ->filterByStore($store);
    }
}
