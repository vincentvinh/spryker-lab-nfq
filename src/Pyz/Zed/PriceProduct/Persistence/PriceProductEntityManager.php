<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\PriceProduct\Persistence;

use Orm\Zed\Currency\Persistence\Map\SpyCurrencyTableMap;
use Orm\Zed\PriceProduct\Persistence\Map\SpyPriceProductDefaultTableMap;
use Orm\Zed\PriceProduct\Persistence\Map\SpyPriceProductStoreTableMap;
use Propel\Runtime\Propel;
use Spryker\Zed\PriceProduct\Dependency\Facade\PriceProductToStoreFacadeBridge;
use Spryker\Zed\PriceProduct\Persistence\PriceProductEntityManager as SprykerPriceProductEntityManager;

/**
 * Class PriceProductEntityManager
 *
 * @package Pyz\Zed\PriceProduct\Persistence
 * @method \Pyz\Zed\PriceProduct\Persistence\PriceProductPersistenceFactory getFactory()
 */
class PriceProductEntityManager extends SprykerPriceProductEntityManager implements PriceProductEntityManagerInterface
{
    /**
     * @param \Spryker\Zed\PriceProduct\Dependency\Facade\PriceProductToStoreFacadeBridge $storeFacade
     * @param array $rates
     *
     * @return void
     */
    public function updatePriceData(PriceProductToStoreFacadeBridge $storeFacade, array $rates)
    {
        $conn = Propel::getConnection();
        $currentCurrency = $storeFacade->getCurrentStore()->getSelectedCurrencyIsoCode();
        $stores = $storeFacade->getStoreTransfersByStoreNames($this->getFactory()->getStore()->getAllStoreNames());
        foreach ($rates as $symbol => $rate) {
            $storeId = $storeFacade->getCurrentStore()->getIdStore();
            foreach ($stores as $store) {
                if (in_array($symbol, $store->getAvailableCurrencyIsoCodes())) {
                    $storeId = $store->getIdStore();
                    break;
                }
            }
            // round value in VND from 123.456 VND to 123.000
            $priceSql = $symbol == 'VND' ? "round(gross_price * $rate/1000)*1000 as gross , round(net_price * $rate/1000)*1000 as net"
                : "gross_price * $rate as gross , net_price * $rate as net";

            $sql = "
                with
                    current_currency as (select id_currency as id from " . SpyCurrencyTableMap::TABLE_NAME . " where code = :symbol ),
                    news  as (select nextval('spy_price_product_store_pk_seq') as id, (select id from current_currency) as currency_id , A.fk_price_product, $storeId , A.gross_price, A.net_price from
                    (select sp.*
                        from " . SpyPriceProductStoreTableMap::TABLE_NAME . " sp
                        join " . SpyCurrencyTableMap::TABLE_NAME . " sc on fk_currency = sc.id_currency
                        where sc.code = :current ) A
                    left join
                        (select sp.*
                        from " . SpyPriceProductStoreTableMap::TABLE_NAME . " sp
                        join " . SpyCurrencyTableMap::TABLE_NAME . " sc on fk_currency = sc.id_currency
                        where sc.code = :symbol ) B
                    on A.fk_price_product = B.fk_price_product
                    where B.fk_price_product is null),

                    A as (insert into " . SpyPriceProductStoreTableMap::TABLE_NAME . "(id_price_product_store, fk_currency, fk_price_product, fk_store, gross_price, net_price) select * from news),
                    B as (insert into " . SpyPriceProductDefaultTableMap::TABLE_NAME . "(id_price_product_default, fk_price_product_store) select nextval('spy_price_product_default_pk_seq'), id from news),
                    C as (update " . SpyPriceProductStoreTableMap::TABLE_NAME . " sp
                        set gross_price = A.gross, net_price  = a.net
                        from
                        (select fk_price_product , $priceSql
                            from " . SpyPriceProductStoreTableMap::TABLE_NAME . " sp
                            join " . SpyCurrencyTableMap::TABLE_NAME . " sc on fk_currency = sc.id_currency
                            where sc.code = :current
                        ) A
                        where  A.fk_price_product = sp.fk_price_product
                        and sp.fk_currency in (
                            select id_currency from " . SpyCurrencyTableMap::TABLE_NAME . " where code = :symbol
                        )
                    )
                select * from news;
            ";

            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':current', $currentCurrency);
            $stmt->bindValue(':symbol', (string)$symbol);

            $stmt->execute();
        }
    }
}
