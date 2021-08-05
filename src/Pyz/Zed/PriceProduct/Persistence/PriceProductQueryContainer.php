<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\PriceProduct\Persistence;

use Spryker\Zed\PriceProduct\Persistence\PriceProductQueryContainer as SprykerPriceProductQueryContainer;

class PriceProductQueryContainer extends SprykerPriceProductQueryContainer implements PriceProductQueryContainerInterface
{
    /**
     * @param string $currency
     *
     * @return mixed|\Orm\Zed\Discount\Persistence\SpyDiscountAmountQuery|\Orm\Zed\PriceProduct\Persistence\SpyPriceProductStoreQuery|\Orm\Zed\PriceProductSchedule\Persistence\SpyPriceProductScheduleQuery|\Orm\Zed\ProductOption\Persistence\SpyProductOptionValuePriceQuery|\Orm\Zed\SalesOrderThreshold\Persistence\SpySalesOrderThresholdQuery|\Orm\Zed\Shipment\Persistence\SpyShipmentMethodPriceQuery
     */
    public function queryPriceProductStoreByCurrency(string $currency)
    {
        return $this->getFactory()
            ->createPriceProductStoreQuery()
            ->joinWithCurrency()
            ->useCurrencyQuery()
                ->filterByCode($currency)
            ->endUse();
    }
}
